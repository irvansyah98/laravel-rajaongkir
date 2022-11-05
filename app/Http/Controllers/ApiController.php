<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as RequestGuzzle;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validation error",
                "data" => null,
                "validation_error" => $validator->errors(),
            ]);
        }

        // check if entered email exists in db
        $user = User::where("email", $request->email)->first();

        // if email exists then we will check password for the same email
        if ($user) {
            // if password is correct
            try {
                if (!($token = JWTAuth::attempt($credentials))) {
                    return response()->json([
                        "success" => false,
                        "message" => "Unable to login. Incorrect password.",
                        "data" => null,
                    ]);
                }
            } catch (JWTException $e) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Could not create token",
                        "data" => null,
                    ],
                    500
                );
            }

            $user = $this->userDetail($request->email);
            $user["token"] = $token;

            return response()->json([
                "success" => true,
                "message" => "You have logged in successfully",
                "data" => $user,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Unable to login. email doesn't exist.",
                "data" => null,
            ]);
        }
    }

    public function userDetail($email)
    {
        return filled($email)
            ? User::where("email", $email)
                ->first()
            : [];
    }

    public function provinceSearch(Request $request)
    {
        if(env('REQUEST_TYPE') == 'DB'){
            $result = Province::query();
            
            if($request->has('id')){
                $result = $result->where('province_id',$request->id);
            }
            
            $result = $result->orderBy("id", "desc")->get();
        }elseif(env('REQUEST_TYPE') == 'RAJAONGKIR'){
            $client = new Client();

            $province = new RequestGuzzle('GET', 'https://api.rajaongkir.com/starter/province');
            
            $response_province = $client->send($province, [
                'query' => [
                    'key' => env('API_KEY_RAJAONGKIR','0df6d5bf733214af6c6644eb8717c92c'),
                    'id' => $request->id
                ]
            ]);

            $result_province = json_decode($response_province->getBody(),true);
            $result = $result_province['rajaongkir']['results'];

        }else{
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Not Found",
            ]);
        }

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
        if(env('REQUEST_TYPE') == 'DB'){
            $result = City::query();
            
            if($request->has('id')){
                $result = $result->where('city_id',$request->id);
            }
            
            $result = $result->orderBy("id", "desc")->get();
        }elseif(env('REQUEST_TYPE') == 'RAJAONGKIR'){
            $client = new Client();

            $city = new RequestGuzzle('GET', 'https://api.rajaongkir.com/starter/city');
            
            $response_city = $client->send($city, [
                'query' => [
                    'key' => env('API_KEY_RAJAONGKIR','0df6d5bf733214af6c6644eb8717c92c'),
                    'id' => $request->id
                ]
            ]);

            $result_city = json_decode($response_city->getBody(),true);
            $result = $result_city['rajaongkir']['results'];

        }else{
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Not Found",
            ]);
        }

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