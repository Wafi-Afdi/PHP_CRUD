# Task Manager API
Ini adalah RESTful API yang dibikin dengan laravel. Untuk dapat menjalankan aplikasinya, ikutin arahan ini:

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/Wafi-Afdi/PHP_CRUD
    cd <project>
    ```

2.  **PHP Dependencies:**
    ```bash
    composer install
    ```

3.  **Configure `.env` File:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Configuration:**
    Update database connection dengan database sendiri. Pastikan database sudah memiliki table `users` dan `tasks`

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_db_username
    DB_PASSWORD=your_db_password
    ```

5.  **JWT Secret Generation:**
    Untuk menciptakan JWT Secret dan menambahkannya ke `.env` file:
    ```bash
    php artisan jwt:secret
    ```


## Dokumentasi Endpoint
Informasi endpoint dapat ditemukan di [Postman](https://www.postman.com/maintenance-participant-74179810/bizera-test/request/4w48uvn/bizera?action=share&creator=35971362&ctx=documentation)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
