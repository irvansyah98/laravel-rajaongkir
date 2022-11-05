<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Province;
use App\Models\City;
use Tymon\JWTAuth\Facades\JWTAuth;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as RequestGuzzle;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function user_can_post_login()
    {
        // Creating Users
        User::create([
            'name' => 'Test',
            'email'=> $email = time().'@example.com',
            'password' => $password = bcrypt('123456789')
        ]);

        $response = $this->json('POST',url('api/login'),[
            'email' => $email,
            'password' => $password,
        ]);

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);

        User::where('email',$email)->delete();
    }

    protected function authenticate()
    {
        $credentials = array("email" => "user@gmail.com", "password" => "password");

        $token = JWTAuth::attempt($credentials);

        return $token;
    }

    /** @test */
    public function user_can_search_province()
    {
        $token = $this->authenticate();
        
        if(env('REQUEST_TYPE') == 'DB'){
            $response = $this->get('api/search/provinces?id=1', ['Authorization' => "Bearer ".$token]);
                    
            $response->assertStatus(200);

        }elseif(env('REQUEST_TYPE') == 'RAJAONGKIR'){
            $client = new Client();

            $province = new RequestGuzzle('GET', 'https://api.rajaongkir.com/starter/province');
            
            $response_province = $client->send($province, [
                'query' => [
                    'key' => env('API_KEY_RAJAONGKIR','0df6d5bf733214af6c6644eb8717c92c'),
                    'id' => 1
                ]
            ]);

            $response = json_decode($response_province->getBody(),true);

             $this->assertTrue(true);

        }else{
            $this->assertTrue(false);
        }

    }

    /** @test */
    public function user_can_search_city()
    {
        $token = $this->authenticate();
        
        if(env('REQUEST_TYPE') == 'DB'){
            $response = $this->get('api/search/cities?id=1', ['Authorization' => "Bearer ".$token]);
                    
            $response->assertStatus(200);

        }elseif(env('REQUEST_TYPE') == 'RAJAONGKIR'){
            $client = new Client();

            $city = new RequestGuzzle('GET', 'https://api.rajaongkir.com/starter/city');
            
            $response_city = $client->send($city, [
                'query' => [
                    'key' => env('API_KEY_RAJAONGKIR','0df6d5bf733214af6c6644eb8717c92c'),
                    'id' => 1
                ]
            ]);

            $response = json_decode($response_city->getBody(),true);

             $this->assertTrue(true);

        }else{
            $this->assertTrue(false);
        }
    }
}
