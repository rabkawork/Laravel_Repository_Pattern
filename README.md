### Postman

[Goto Postman documentation](github.com/rabkawork/be-technicaltest/postman/Test.postman_collection.json)

### How to deploy App

1. Copy .env.example to .env
    ```shell
    cp .env.example .env
    ```
2. Composer Instal
    ```shell
    composer install
    ``
3. Running migration
    ```shell
    php artisan migrate:fresh --seed
    ```
4. Running project
    ```shell
    php artisan server -> http://localhost:8000
    ```
5. Running test
    ```shell
    php artisan test
    ```

## Tech use

1. PHP 8.1 
2. Larvael 8
3. Mariadb 10.5


