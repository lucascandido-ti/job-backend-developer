<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterProduct;
use App\Http\Requests\UpdateProduct;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
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
            return ProductResource::collection(Product::all());
        } catch (\Throwable $th) {
            return $this->returnGenericError($th);
        }
    }


    /**
     * Find any products
     * @link /api/admin/products/search
     *
     * @param Request Object to request
     * @return json Object with response
     */
    public function search(Request $request){
        //
    }

    /**
     * Get product on database
     * @link /api/admin/products/show
     *
     * @param Request Object to request
     * @return json Object with response
     */
    public function show(Product $product){
        return new ProductResource($product);
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

            $product = Product::create($request->only('name','price','description','category','image_url'));
            return response(new ProductResource($product), Response::HTTP_CREATED);

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

            $product->update($request->only('name','price','description','category','image_url'));
            return response(new ProductResource($product), Response::HTTP_ACCEPTED);

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

            $product->delete();
            return response(null, Response::HTTP_NO_CONTENT);
            
        } catch (\Throwable $th) {
            return $this->returnGenericError($th);
        }
    }
}
