# Laravel Hackernews API

This project is a RESTful API built with Laravel that serves data from the popular news site Hackernews.

## Getting Started

To get started, you'll need to clone this repository and install the dependencies. Here are the steps:

1. Clone the repository:

    ```
    git clone https://github.com/yourusername/laravel-hackernews-api.git
    ```

2. Navigate to the project directory:

    ```
    cd laravel-hackernews-api
    ```

3. Install the dependencies:

    ```
    composer install
    ```

4. Copy the .env.example file and rename it to .env:

    ```
    cp .env.example .env
    ```

5. Generate a new application key:

    ```
    php artisan key:generate
    ```

6. Set up the database by setting the necessary variables in the .env file:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=hackernews
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7. Run the database migrations:

    ```
    php artisan migrate
    ```

8. Seed the database with data from Hackernews:

    ```
    php artisan db:seed
    ```

9. Start the server:

    ```
    php artisan serve
    ```

10. You're all set! You can now make requests to the API at http://localhost:8000/api.

## Endpoints

Here are the available endpoints:

- `GET /api/spool/max`: Gets the maximum item ID.
- `GET /api/spool/top`: Gets the top stories.
- `GET /api/spool/new`: Gets the newest stories.
- `GET /api/spool/show`: Gets a specific story.
- `GET /api/spool/ask`: Gets the latest Ask HN posts.
- `GET /api/spool/job`: Gets the latest job posts.
- `GET /api/spool/best`: Gets the best stories.

## Contributing

Contributions are welcome! If you have an idea for a new feature or would like to fix a bug, please create a new issue or submit a pull request.

## License

This project is open source and available under the [MIT License](https://opensource.org/licenses/MIT).
