## Cara Penggunaan Sprint 1

1. <b>First Step jika belum instal di local Server </b>

- Clone project ke htdocs ``git clone https://github.com/irvansyah98/laravel-rajaongkir.git``
- lakukan ``composer install``

2. <b>Second Step jika sudah instal di local Server </b>

- pindah branch dengan ``git checkout sprint1``
- buat file .env dan copy paste isi dari file .env.example ke .env
- lakukan ``composer update``
- buat database dengan nama 'rajaongkir'
- lakukan ``php artisan migrate:refresh --seed``

3. <b>Testing hasil Test</b>

- Dokumentasi Postman <https://documenter.getpostman.com/view/2089481/2s8YYEPQmV>
- melakukan fetching API data provinsi & kota dengan command ``php artisan add:provincecity``
- run project dengan ``php artisan serve``
- kemudian testing API sesuai dokumentasi postman yang sudah diberikan
