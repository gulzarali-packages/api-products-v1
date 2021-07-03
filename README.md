# laravel-api-sample

below is the db schema for the project
* https://jmp.sh/zCtm6fD

To setup it locally just follow below steps after cloning the repository.
* change its initial configuration through adding .env file and generate app key
* composer install
* php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
* php artisan migrate

Thats it.
* now register a user by accessing rout as http://127.0.0.1:8000/register
* use returned token to make api requests

To take a look at json response collection taken using postman navigate to the below path
* https://github.com/gulzarali-packages/api-products-v1/tree/master/postman-collections



.
