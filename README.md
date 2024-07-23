# Laravel Data Provider API

This is a Laravel-based API that merges and filters data from two different providers and provides various filtering options.

---

## Requirements

- Docker
- Docker Compose
- Composer

---

## Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/SeniorMahmoudBadr/Data-Provider-Api.git
   cd Data-Provider-Api

2. Copy the .env.example to .env:
    ```bash
    cp .env.example .env

3. Update the .env file with your database configuration:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=laravel
    DB_PASSWORD=secret

4. Build and start the Docker containers:
    ```bash
    docker-compose up -d
   
5. Install Composer dependencies:
    ```bash
    docker-compose exec app composer install
   
6. Generate the application key:
    ```bash
   docker-compose exec app php artisan key:generate

   
7. Run the database migrations:
    ```bash
   docker-compose exec app php artisan migrate

---

## Testing the API

1. Import the Postman collection to your Postman app:
   * Open Postman
   * Click on Import
   * Select the file TaskDataProviderApi.postman_collection.json

2. The collection includes various endpoints to test the API functionalities.

---

## Running Unit Tests

1. To run the unit tests, use the following command:
    ```bash
    docker-compose exec app ./vendor/bin/phpunit

---

## API Endpoints
1. Get All Users
     ```http
    GET /api/v1/users
   
2. Filter Users by Provider
    ```http
   GET /api/v1/users?provider=DataProviderX

   
3. Filter Users by Status Code
    ```http
   GET /api/v1/users?statusCode=authorised

4. Filter Users by Balance Range
    ```http
   GET /api/v1/users?balanceMin=100&balanceMax=500

5. Filter Users by Currency
    ```http
   GET /api/v1/users?currency=USD

6. Pagination
    ```http
   GET /api/v1/users?paginate=1&perPage=10&page=2
   
---
## License
This project is licensed under the MIT License.

This `README.md` provides a clear structure for setting up and running your Laravel application, including API testing with Postman and running unit tests.

