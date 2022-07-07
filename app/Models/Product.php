<?php

namespace App\Models;

use App\Events\ProductCreatedEvent;
use App\Events\ProductUpdatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => ProductCreatedEvent::class,
        'updated' => ProductUpdatedEvent::class,
        'deleted' => ProductUpdatedEvent::class,
    ];

}
