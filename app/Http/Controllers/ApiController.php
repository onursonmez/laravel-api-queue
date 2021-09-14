<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\App;
use App\Models\Device;
use App\Models\Timezone;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /*
    * Our all applications
    *
    * @return JsonResponse
    */
    public function getApps()
    {
        return response()->json(
            App::select(['id', 'title'])->orderBy('id')->get()
        );
    }

    /*
    * Our all timezones
    *
    * @return JsonResponse
    */
    public function getTimezones()
    {
        return response()->json(
            Timezone::select(['id', 'title'])->orderBy('id')->get()
        );
    }

    /*
    * If a device runs or click to register button
    *
    * TODO: On production state, we will generate
    * JWT tokens for every registered devices and
    * we will remove token column in devices table
    *
    * @param app_id int
    * @param uid string
    * @param language int
    * @param os int
    * @param timezone int
    * @param token string
    * @return JsonResponse
    */
    public function registerDevice(request $request)
    {
        $response = ['message' => null, 'token' => null];

        $validate_data = $request->validate([
            'app_id'        => 'required|integer',
            'uid'           => 'required|string',
            'language'      => 'required|integer',
            'os'            => 'required|integer',
            'timezone'      => 'required|integer'
        ]);

        $where = [
            "app_id"        => $request->get('app_id'),
            "uid"           => $request->get('uid'),
            "os"            => $request->get('os')
        ];
        $check = $this->getDeviceByCredinentals($where);

        if(!empty($check))
        {
            $response['message'] = "You're already registered!";
            $response['token'] = $check->token;
        }
        else
        {
            $device = new Device;
            $token = md5(time() . env('SECRET')); // bad idea instead of JWT but it works temporarily

            $device->created_at     = Carbon::now('UTC'); // we are always write dates to database from UTC
            $device->app_id         = $request->get('app_id');
            $device->uid            = $request->get('uid');
            $device->language       = $request->get('language');
            $device->os             = $request->get('os');
            $device->timezone       = $request->get('timezone');
            $device->token          = $token;
            $device->save();

            $response['message'] = "You are now registered!";
            $response['token'] = $token;
        }

        return response()->json($response);
    }

    /*
    * Our latest 10 registered devices
    *
    * @return JsonResponse
    */
    public function getRegisteredDevices()
    {
        return response()->json(
            Device::select(['id', 'app_id', 'uid', 'created_at', 'token'])->limit(10)->orderBy('id', 'desc')->get()
        );
    }

    /*
    * A device purchase process
    *
    * @param Request $request
    * @return jsonResponse
    */
    public function newPurchase(request $request)
    {
        $response = ['status' => false, 'expire' => null, 'message' => null];

        // RED: If requests are not validated
        $validate_data = $request->validate([
            'receipt'       => 'required|integer',
            'token'         => 'required|string|exists:devices',
        ]);

        // RED: If device is not exist
        $device = Device::where('token', $request->get('token'))->firstOrFail();

        // RED: Already purchased and active
        $inline_request = new Request([
            'token'   => $request->get('token'),
            'receipt' => $request->get('receipt'),
            'status' => 1,
        ]);
        $checkSubscriptionJsonObjectResponse = $this->checkSubscription($inline_request);
        $checkSubscription = $checkSubscriptionJsonObjectResponse->getData();
        if($checkSubscription->status == true)
        {
            $response['message'] = "You're already purchased!";
            return response()->json(['message' => $response['message']], 422);
        }

        // Ask to API services
        $response = $this->checkReceipt([
            'os' => $device->os,
            'receipt' => $request->get('receipt'),
            'token' => $request->get('token'),
        ]);

        // RED: If related API service returns error
        if($response['status'] == false)
        {
            return response()->json(['message' => $response['message']], 422);
        }

        // GREEN: All is OK, purchase that
        else
        {
            $order = new Order;
            $order->start_at = Carbon::now('UTC'); // we are always write dates to database from UTC
            $order->end_at = Carbon::parse($response['expire'], 'America/Chicago')->setTimezone('UTC'); // convert GMT-6 to UTC
            $order->status = 1;
            $order->device_id = $device->id;
            $order->receipt = $request->get('receipt');
            $order->save();

            return response()->json($response);
        }
    }

    /*
    * We are validating the receipt via
    * App Store or Play Store services
    *
    * @param array $params
    * @return void
    */
    public function checkReceipt($params)
    {
        switch($params['os'])
        {
            case 1: //App Store
                return $this->checkReceiptFromAppStore($params);
            break;

            case 2: //Play Store
                return $this->checkReceiptFromPlayStore($params);
            break;
        }
    }

    /*
    * If a device ran or manually user click to re-check
    * button, we are checking subscription status
    *
    * @param int $device_id
    * @param int $status
    * @return JsonResponse
    */
    public function checkSubscription(request $request)
    {
        $response = ['status' => false, 'expire' => null];

        // RED: If requests are not validated
        $validate_data = $request->validate([
            'token'         => 'required|string|exists:devices',
            'status'        => 'required|int',
        ]);

        // RED: If device is not exists
        if($device = $this->getDeviceByCredinentals(['token' => $request->get('token')]))
        {
            $timezone = Timezone::findOrFail($device->timezone);
            $order = Order::where('device_id', $device->id)->where('app_id', $device->app_id)->where('status', $request->get('status'))->where('end_at', '>', Carbon::now('UTC'));

            if($request->get('receipt'))
            $order = $order->where('receipt', $request->get('receipt'));

            $order = $order->first();

            // GREEN: Subscription is active
            if(!empty($order))
            {
                $response['status'] = true;
                $response['expire'] = Carbon::parse($order->end_at, 'UTC')->setTimezone($timezone->code)->format('Y-m-d H:i:s');
                $response['timezone'] = $timezone->title;
            }
        }

        return response()->json($response);
    }

    /*
    * @param array $params
    * @return array $response
    */
    private function checkReceiptFromAppStore($params)
    {
        $response = ['status' => false, 'expire' => null, 'message' => null];

        if($params['receipt'] % 2 == 0)
        {
            $response['message'] = 'The receipt could not be verified!';
        }
        else
        {
            $response['status'] = true;
            $response['expire'] = Carbon::now('UTC')->setTimezone('America/Chicago')->addMonth(2)->format('Y-m-d H:i:s'); //GMT-6
        }

        return $response;
    }

    /*
    * @param array $params
    * @return array $response
    */
    private function checkReceiptFromPlayStore($params)
    {
        $response = ['status' => false, 'expire' => null, 'message' => null];

        if($params['receipt'] % 2 == 0)
        {
            $response['message'] = 'Receipt is not validated!';
        }
        else
        {
            $response['status'] = true;
            $response['expire'] = Carbon::now('UTC')->setTimezone('America/Chicago')->addMonth(2)->format('Y-m-d H:i:s'); //GMT-6
        }
        return $response;
    }

    /*
    * @param array $params
    * @return EloquentObject $response
    */
    private function getDeviceByCredinentals($params)
    {
        $response = Device::where($params)->first();

        return $response;
    }

    /*
    * Our worker checking their subscription status
    */
    public function worker()
    {
        $order = Order::with('device')->find(1);
        \App\Jobs\checkSubscription::dispatch($order)->onConnection('database')->onQueue('high');
        // php artisan queue:work database --queue=high --tries=3

        /*
            1. Bu worker dakikada bir typesense veritabanina giderek n adet expire date'i gecmis kaydi ceker (ornek verecegim)
            2. Gelen kayitlar dondurulerek yukaridaki ornekteki gibi checkSubscription jobs'a atilir
            3. CheckSubscription job'u istege bagli tekrar denemeleri ile isleri kuyruklayarak API servislerine gider ve kontrol yapar
            4. Kontrol sonrasi ilgili order tablosunu guncellenir
            5. Order tablosunda etkilesim oldugu anda Observer yakalar ve 3rd party endpoint call edilir
        */
    }
}
