<?php

namespace App\Http\Services;

use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class SearchProductService extends Model{

    protected $fillable = [
        'entry',
        'output'
    ];

    public function __construct($request)
    {
        $this->entry = new stdClass;
        $this->entry->id             = array_key_exists('id',$request) ? $request['id'] : '';
        $this->entry->name           = array_key_exists('name',$request) ? $request['name'] : '';
        $this->entry->price          = array_key_exists('price',$request) ? $request['price'] : '';
        $this->entry->description    = array_key_exists('description',$request) ? $request['description'] : '';
        $this->entry->category       = array_key_exists('category',$request) ? $request['category'] : '';
        $this->entry->with_image     = array_key_exists('with_image',$request) ? $request['with_image'] : '';
    }

    public function process(){

        $products = DB::select(SearchProductService::setUpQuery());
        $this->output = ProductResource::collection($products);

    }

    private function setUpQuery(){
        $select = " SELECT *
                    FROM products
                    WHERE 1 = 1 ";

        if($this->entry->id != ""){
            $select .= " AND id = ".$this->entry->id." ";
        }

        if($this->entry->name != ""){
            $select .= " AND name = '".$this->entry->name."' ";
        }

        if($this->entry->category != ""){
            $select .= " AND category = '".$this->entry->category."' ";
        }

        if($this->entry->with_image == 1){
            $select .= " AND image_url <> '' ";
        }else if($this->entry->with_image == 0){
            $select .= " AND image_url = '' ";
        }

        return $select;
    }

}

