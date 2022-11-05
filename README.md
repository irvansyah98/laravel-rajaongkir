## Cara Penggunaan Sprint 2

1. <b>First Step jika belum instal di local Server </b>

- Clone project ke htdocs ``git clone https://github.com/irvansyah98/laravel-rajaongkir.git``
- lakukan ``composer install``

2. <b>Second Step jika sudah instal di local Server </b>

- pindah branch dengan ``git checkout sprint2``
- buat file .env dan copy paste isi dari file .env.example ke .env
- lakukan ``composer update``
- buat database dengan nama 'rajaongkir'
- lakukan ``php artisan migrate:refresh --seed``

3. <b>Testing hasil Test</b>

- Dokumentasi Postman <https://documenter.getpostman.com/view/2089481/2s8YYEPQmV>
- Proses swap implementasi dapat dilakukan melalui konfigurasi di .env dengan nama REQUEST_TYPE
- REQUEST_TYPE berisi 2 value, jika value REQUEST_TYPE=DB maka api akan hit otomatis pencarian province & cities dari database, jika value REQUEST_TYPE=RAJAONGKIR maka api akan hit otomatis pencarian province & cities dari server rajaongkir
- run project dengan ``php artisan serve``
- kemudian testing API sesuai dokumentasi postman yang sudah diberikan di folder Sprint 2
- Credential Login email => user@gmail.com, password => password

4. <b>Unit Test</b>

- lakukan unit test dengan command ``vendor/bin/phpunit tests/Feature/ApiTest.php``
