<?php

namespace App\Http\Services;

use App\Events\ProductUpdatedEvent;
use App\Http\Repository\ExternalAPIRepository;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ImportProductByAPIService{

    protected $product_id;

    public function __construct($product_id = 0)
    {
        $this->product_id = (int)$product_id;
    }

    public function process(){

        $service = new ExternalAPIRepository();
        $products = $this->processAndFormatResult($service);

        foreach($products as $product){
            $this->uploadProduct($product);
        }

        event(new ProductUpdatedEvent);
    }

    private function uploadProduct($data){

        $product_id = $this->findProductByName(trim($data->title));

        if(!$product_id){

            Product::create([
                "name"          => trim($data->title),
                "price"         => $data->price,
                "description"   => trim($data->description),
                "category"      => trim($data->category),
                "image_url"     => trim($data->image),
            ]);

        }else{

            $product = Product::find($product_id);

            $product->update([
                "name"          => trim($data->title),
                "price"         => $data->price,
                "description"   => trim($data->description),
                "category"      => trim($data->category),
                "image_url"     => trim($data->image),
            ]);

        }
    }

    private function processAndFormatResult($service){

        $products = json_decode($service->getProducts($this->product_id));

        if(is_object($products)){
            $products = [$products];
        }

        return $products;
    }

    public function findProductByName($name){

        $product = Product::select('*')->where('name','=',$name)->first();

        if($product != []){
            $product = Product::find($product->id);
            return $product->id;
        }else{
            return false;
        }
    }
}