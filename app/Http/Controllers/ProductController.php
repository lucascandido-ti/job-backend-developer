<?php

namespace App\Http\Controllers;

use App\Events\ProductCreatedEvent;
use App\Events\ProductUpdatedEvent;
use App\Http\Repository\ProductRepository;
use App\Http\Requests\RegisterProduct;
use App\Http\Requests\UpdateProduct;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Services\SearchProductService;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * List all products
     * @method GET
     * @link /api/admin/products
     *
     * @param Request Object to request
     * @return json Object with response
     */
    public function index(){
        try {
            
            $products = ProductRepository::findAll();
            return $products;
            
        } catch (\Throwable $th) {
            return $this->returnGenericError($th);
        }
    }


    /**
     * Get product on database
     * @link /api/admin/products/show
     *
     * @param Request Object to request
     * @return json Object with response
     */
    public function show(Product $product){
        try {
            $product = ProductRepository::find($product);
            return response($product, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->returnGenericError($th);
        }
    }


    /**
     * Search products
     * @link /api/admin/products/search
     *
     * @param Request Object to request
     * @return json Object with response
     */
    public function search(Request $request){
        try {

            $products = ProductRepository::searchProducts($request);
            return response($products, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return $this->returnGenericError($th);
        }
    }

    /**
     * Insert new product on database
     * @link /api/admin/products/store
     *
     * @param Request Object to request
     * @return json Object with response
     */
    public function store(RegisterProduct $request){
        try {

            $product = ProductRepository::store($request);
            return response($product, Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->returnGenericError($th);
        }
    }

    
    /**
     * Updated Product on database
     * @link /api/admin/products/update
     *
     * @param Request Object to request
     * @return json Object with response
     */
    public function update(UpdateProduct $request, Product $product){
        try {

            $product = ProductRepository::updateProduct($request, $product);
            return response($product, Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->returnGenericError($th);
        }
    }

    
    /**
     * Delete Product on database
     * @link /api/admin/products/store
     *
     * @param Request Object to request
     * @return json Object with response
     */
    public function destroy(Product $product){
        try {

            $product = ProductRepository::deleteProduct($product);
            return response($product, Response::HTTP_NO_CONTENT);
            
        } catch (\Throwable $th) {
            return $this->returnGenericError($th);
        }
    }



}
