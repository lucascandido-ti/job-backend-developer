<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class ProductUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::send('mail-product-created',["product"=>$event->product],function($m){
            $m->from("teste@teste.com.br");
            $m->to("teste@teste.com.br");
            $m->subject("Product Update");
        });
        Cache::forget('registered_products');
    }
}
