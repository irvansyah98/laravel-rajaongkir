<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use App\Models\City;
use App\Models\Province;

class AddProvinceCity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:provincecity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Province and City to Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();

        $province = new Request('GET', 'https://api.rajaongkir.com/starter/province');
        $response_province = $client->send($province, [
            'query' => [
                'key' => env('API_KEY_RAJAONGKIR','0df6d5bf733214af6c6644eb8717c92c'),
            ]
        ]);

        $result_province = json_decode($response_province->getBody(),true);

        \DB::table('provinces')->delete();

        foreach($result_province['rajaongkir']['results'] as $item){
            Province::create([
                'province_id' => $item['province_id'],
                'province' => $item['province']
            ]);
        }

        $city = new Request('GET', 'https://api.rajaongkir.com/starter/city');
        $response_city = $client->send($city, [
            'query' => [
                'key' => env('API_KEY_RAJAONGKIR','0df6d5bf733214af6c6644eb8717c92c'),
            ]
        ]);

        $result_city = json_decode($response_city->getBody(),true);

        \DB::table('cities')->delete();

        foreach($result_city['rajaongkir']['results'] as $item){
            City::create([
                'city_id' => $item['city_id'],
                'province_id' => $item['province_id'],
                'province' => $item['province'],
                'type' => $item['type'],
                'city_name' => $item['city_name'],
                'postal_code' => $item['postal_code'],
            ]);
        }

        $this->info('Data added successfully');
    }
}
