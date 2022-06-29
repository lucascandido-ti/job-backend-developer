<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function returnGenericError(\Throwable $th){
        $error = __("processing.generic_error");
        $error["ex.message"] = str_replace("{replace}", $th->getMessage(), $error["ex.message"]);
        return response()->json($error)->setStatusCode($error["code"]);
    }
}
