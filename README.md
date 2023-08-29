# HeyTutor Senior Backend Engineer Challenge

## This is a simple PHP Laravel application to exhibit abilities as design a system, desing a DB, routes with specific objectives, complex SQL queries and ability to learn new things

### stack used
- PHP 8.2
- Composer 2.5.8
- Laravel 10.21

## How to run the project
- Install PHP
  - On Windows: https://www.sitepoint.com/how-to-install-php-on-windows/
  - On Linux: https://computingforgeeks.com/how-to-install-php-8-2-on-ubuntu/
- Install Composer
    - On windows: https://www.javatpoint.com/how-to-install-composer-on-windows#:~:text=Using%20Installer&text=Under%20the%20%22Installation%20%2D%20Windows%22,install%20and%20follow%20the%20instructions.
    - On Linux: https://operavps.com/docs/install-php-composer-in-linux/
- Create database
  - After creating, remember to configure the necessary fields on .env to match your database configuration <br>
    DB_CONNECTION=mysql <br>
    DB_HOST=127.0.0.1 <br>
    DB_PORT=3306 <br>
    DB_DATABASE= <br>
    DB_USERNAME= <br>
    DB_PASSWORD= <br>

- Clone the repo and inside the project folder with a terminal of your choice, do the following
    - Run `composer install`
    - Run the migrations and the seeders with the command `php artisan migrate:fresh --seed` 
