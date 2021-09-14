<?php

namespace App\Observers;

use Illuminate\Support\Facades\Log;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        //TODO: Typesense tarafina kaydedilecek
        //TODO: 3rd party endpont call edilecek
        Log::info('Order created');
    }

    public function saved(Order $order)
    {
        //TODO: Typesense tarafina kaydedilecek
        //TODO: 3rd party endpont call edilecek
        Log::info('Order saved');
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //TODO: Typesense tarafindaki veri guncellenecek
        //TODO: 3rd party endpont call edilecek
        Log::info('Order updated');
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
