# HeyTutor Senior Backend Engineer Challenge 

## This is a simple PHP Laravel application to exhibits abilities such as designing a system, routes with specific objectives, complex SQL queries, and the ability to learn new things

 ### Stack Used
- PHP 8.2 <br>
- Composer 2.5.8 <br>
- Laravel 10.21 <br>
- PHPUnit 10.3.2
- Mysql 8.0.34
### How to run the project
- Install PHP <br>
    - [On Windows](https://www.sitepoint.com/how-to-install-php-on-windows/) <br>
    - [On Linux](https://computingforgeeks.com/how-to-install-php-8-2-on-ubuntu/) <br>
- Install Composer <br>
    - [On windows](https://www.javatpoint.com/how-to-install-composer-on-windows#:~:text=Using%20Installer&text=Under%20the%20%22Installation%20%2D%20Windows%22,install%20and%20follow%20the%20instructions.) <br>
    - [On Linux](https://operavps.com/docs/install-php-composer-in-linux/)
- Create database <br>
  - In this project, the database used is Mysql for the application and in-memory SQLite for testing
  - Be sure to enable the drivers for MySQL and SQLite in the php.ini file or install them via the command line
  - After creating, remember to configure the necessary fields on .env to match your database configuration <br>
    DB_CONNECTION <br>
    DB_HOST <br>
    DB_PORT <br>
    DB_DATABASE <br>
    DB_USERNAME <br>
    DB_PASSWORD

- Clone the repo and inside the project folder with a terminal of your choice, do the following
    - Run `composer install`. This operation may take a few minutes the first time it is executed
    - Run the migrations and the seeders with the command `php artisan migrate:fresh --seed`
    - Run the application with `php artisan serve`. By default, the port is 8000 but it can be customized using `php artisan serve --port {desired-port}`, changing  {desired-port} for the one of your choice <br> <br>
Now the application is up and its endpoints can be accessed

- PHPUnit
    - Enable SQLite on your php.ini file or install it via command line, as the tests use an in-memory SQLite database   
    - To run all the tests, just open the terminal on the project folder and run `./vendor/bin/phpunit`

## How to access the endpoints
   - Now that the application is running, you can access the endpoints using the api test tool like [postman](https://www.postman.com/) or [insomnia](https://insomnia.rest/)<br>

### GET /api/users/order/most-expensive
   - A route that returns all users and their most expensive order - Example response
    
    {
    	"users": [
    		{
    			"name": "Sigrid Jakubowski",
    			"mostExpensivePurchase": "827.91",
    			"currency": "usd"
    		},
    		{
    			"name": "Amina Frami",
    			"mostExpensivePurchase": "741.60",
    			"currency": "usd"
    		},
    		{
    			"name": "Hertha O'Keefe IV",
    			"mostExpensivePurchase": "716.58",
    			"currency": "usd"
    		},
    		{
    			"name": "Thad Von",
    			"mostExpensivePurchase": "704.40",
    			"currency": "usd"
    		},
    		{
    			"name": "Prof. Jamaal Wiza",
    			"mostExpensivePurchase": "659.20",
    			"currency": "usd"
    		}
    	]
    }

### GET /api/users/purchased-all-products 
- A route that returns all users that have bought all the products on the system - Example response   
<pre>
    {
        "users": [
            {
                "name": "Thad Von"
            },
            {
                "name": "Amina Frami"
            }
        ]
    }
</pre>
    
### GET /api/users/highest-total-orders
- A route that returns the user (or users if they have the same value of total order) that have the highest order value - Example response   
<pre>
    {
    	"users": [
    		{
    			"name": "Sigrid Jakubowski",
    			"totalOrderValue": "8397.96",
    			"currency": "usd"
    		}
    	]
    }
</pre>
