<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function provinceSearch(Request $request)
    {
        $result = Province::query();
        
        if($request->has('id')){
            $result = $result->where('province_id',$request->id);
        }
        
        $result = $result->orderBy("id", "desc")->get();

        if (count($result) > 0) {
            return response()->json([
                "success" => true,
                "data" => $result,
                "message" => "Success",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Not Found",
            ]);
        }
    }

    public function citySearch(Request $request)
    {
        $result = City::query();
        
        if($request->has('id')){
            $result = $result->where('city_id',$request->id);
        }
        
        $result = $result->orderBy("id", "desc")->get();

        if (count($result) > 0) {
            return response()->json([
                "success" => true,
                "data" => $result,
                "message" => "Success",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Not Found",
            ]);
        }
    }
}