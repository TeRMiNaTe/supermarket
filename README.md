## Project details

This is a basic supermarket implementation built on Laravel.
The supermarket includes products with different prices and discounts for bulk purchases of the same product.
The discounts must be applied regardless of the order of the products.

Here's what's included:
- Simple checkout & order review pages
- Request validation
- Microservices managing the order & discount processes
- Seeders with some initial product data

| Item | Unit Price | Special Price |
|------|------------|---------------|
| A    | 50         | 3 for 130     |
| B    | 30         | 2 for 45      |
| C    | 20         |               |
| D    | 10         |               |

## Setup through Laravel Sail
Laravel Sail will build all of the necessary containers in Docker. See [Laravel Sail Installation & Setup](https://laravel.com/docs/10.x/sail#installation)

Prerequisites:
- Docker
- Composer
- PHP

Setup:
1. Clone the repo locally
2. Run `composer run-script smooth-sailing` script to install the project.
3. The application should now be visible at http://localhost

That's it!

What happens under the hood:
1. `composer install --ignore-platform-reqs` Downloads all composer dependencies
2. `@php -r \"file_exists('.env') || copy('.env.example', '.env');\"` Creates a default .env configuration file
3. `@php artisan key:generate` Creates a new application key
4. `@php artisan sail:add mysql` Adds the mysql service to the sail configuration
5. `./vendor/bin/sail build --no-cache` Builds the sail configuration
6. `./vendor/bin/sail up -d` Runs sail as a background service
7. `./vendor/bin/sail artisan migrate:fresh --seed` Seeds the database with some initial product data

Alternatively, you could look into different Laravel Installation methods - see [Laravel Installation](https://laravel.com/docs/10.x/installation)

## Testing

You can run `sail test` to run the application tests.
The tests run on an isolated "testing" DB so that they do not interfere with the actual application data.
