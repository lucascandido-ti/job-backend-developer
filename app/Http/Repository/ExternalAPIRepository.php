<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\Http;

class ExternalAPIRepository{
    private string $api_url = "https://fakestoreapi.com/";

    public function getAll(){
        $endpoint = "products";
        $response = $this->getRequest($endpoint);

        return $response->body();
    }

    public function findById($id){
        $endpoint = "products/".$id;
        $response = $this->getRequest($endpoint);

        return $response->body();
    }

    private function getRequest($uri,$data = []){
        $response = Http::get($this->api_url.$uri, $data);
        return $response;
    }

}