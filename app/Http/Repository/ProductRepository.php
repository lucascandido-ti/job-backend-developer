<?php

namespace App\Http\Repository;

use App\Events\ProductCreatedEvent;
use App\Events\ProductUpdatedEvent;
use App\Http\Requests\UpdateProduct;
use App\Http\Resources\ProductResource;
use App\Http\Services\SearchProductService;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductRepository extends Model{
    

    public static function find(Product $product){
        return new ProductResource($product);
    }

    public static function findAll(){
        if(Cache::has('registered_products')){
            return Cache::get('registered_products');
        }

        $products = ProductResource::collection(Product::all());
        Cache::put('registered_products', $products, 60);

        return $products;
    }

    public static function searchProducts(Request $request){
        $service = new SearchProductService($request->all());
        $service->process();

        return $service->output;
    }

    public static function store(Request $request){
        $product = Product::create($request->only('name','price','description','category','image_url'));
        event(new ProductCreatedEvent($product));
        event(new ProductUpdatedEvent);

        return new ProductResource($product);
    }

    public static function updateProduct(UpdateProduct $request, Product $product){
        
        $product->update($request->only('name','price','description','category','image_url'));
        event(new ProductCreatedEvent($product));
        event(new ProductUpdatedEvent);

        return new ProductResource($product);
    }

    public static function deleteProduct(Product $product){
        $product->delete();
        event(new ProductUpdatedEvent);
        return null;
    }
}