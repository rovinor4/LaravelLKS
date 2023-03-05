<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public static function requestValid(Request $request,$rules,$data){
        $valid = Validator::make($request->all(),$rules);

        $x = [
            "status" => true,
            "message" => null
        ];

        if ($valid->fails()) {
            $x["status"] = false;
            $x["message"] = $valid->errors()->first();
        }else{
            $x["status"] = true;
            $y = null;
            foreach($data as $t){
                $y[$t] = $request[$t];
            }
            $x["message"] = $y;
        }

        return $x;

    }

}
