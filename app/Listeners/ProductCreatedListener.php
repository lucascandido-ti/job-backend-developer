<?php

namespace App\Listeners;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ProductCreatedListener
{

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
            $m->subject("Updated product");
        });
    }
}
