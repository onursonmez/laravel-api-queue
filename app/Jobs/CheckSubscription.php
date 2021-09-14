<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Order;
use App\Http\Controllers\ApiController;

class CheckSubscription implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $apiController = new ApiController;
        $response = $apiController->checkReceipt([
            'os'        => $this->order->device->os,
            'receipt'   => $this->order->receipt
        ]);

        if($response['status'] == false)
        {
            $this->order->status = 3; //iptal ediyoruz
            $this->order->save();
        }
        else
        {
            $this->order->status = 1; //aktif ediyoruz
            $this->order->end_at = \Carbon\Carbon::parse($response['expire'], 'America/Chicago')->setTimezone('UTC')->format('Y-m-d H:i:s'); //GM-6 olarak geliyor UTC'ye cevirdik
            $this->order->save();
        }
    }
}
