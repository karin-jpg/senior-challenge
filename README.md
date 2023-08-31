# HeyTutor Senior Backend Engineer Challenge 

## This is a simple PHP Laravel application to exhibits abilities such as designing a system, routes with specific objectives, complex SQL queries, and the ability to learn new things

### Stack Used
- Docker
    - PHP 8.2 <br>
    - Composer 2.5.8
    - Laravel 10.21
    - PHPUnit 10.3.2
    - Mysql
### How to run the project
- Install Docker and Docker-compose
    - [On Windows](https://docs.docker.com/desktop/install/windows-install/)
    - [On Linux](https://docs.docker.com/desktop/install/linux-install/)
    - [On Mac](https://docs.docker.com/desktop/install/mac-install/)
    
    - This documentation is for downloading the docker desktop that reduces the time spent on complex setups so you can focus on the code

- Make sure that the port 8000 and 3308 are not being used by other processes/programs, as these are the default port for the code application and the MySQL database, respectively

- Clone the repo and do the following:
    - Run `docker-compose up -d` in a terminal on the root of the project folder. The `docker-compose up` will set up the containers and the `-d` flag will make them run in the background.
    - After the previous command you'll have the following 3 containers running
      ![image](https://github.com/karin-jpg/senior-challenge/assets/52075166/1a5c6a4e-beab-43ae-a9d1-f37068b0d042)
      - <b>store</b> is the container that will have the application code
      - <b>store_db</b> is the container that will have the MySQL database
      - <b>store_nginx</b> is the container that will have the nginx server

    - Inside the project folder, create a copy of the file .env.example, rename it to .env, and alter the database configuration to the following
        - DB_CONNECTION=mysql <br>
        - DB_HOST=store_db
        - DB_PORT=3308
        - DB_DATABASE=store
        - DB_USERNAME=root
        - DB_PASSWORD=1234
    - Run `docker exec store composer install` to install all of the laravel dependencies. This step may take a few minutes.
    - Run `docker exec store php artisan key:generate` to generate the key to the APP_KEY value on the .env file.
    - Run `docker exec store php artisan migrate --seed` to run the migrations and seeders of the laravel application
    - After all these steps, your application will be ready and running on port 8000
        - In case you see yourself with an error on storage/laravel.log file, run `docker exec store chown -R www-data storage` to add the permission     

    - PHPUnit  
      - To run all the tests, just open the terminal on the project folder and run `docker exec store ./vendor/bin/phpunit`

## How to access the endpoints
   - Now that the application is running, you can access the endpoints directly on the browser or using an api test tool like [postman](https://www.postman.com/) or [insomnia](https://insomnia.rest/)<br>

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
    Note: As the migration uses random IDs to fill the orders table, sometimes this route can be empty. 
    If this is the case, simply run `docker exec store migrate:fresh --seed` to rerun the migrations and seeders
    
### GET /api/users/highest-total-orders - Example response 
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


### Bonus - multiple instances of application inside nginx
   - On the root folder of Nginx, edit the nginx.conf and add the code `include /etc/nginx/conf.d/*.conf;` so it can find any .conf file that we create
   - Suppose we want to host app1.com and app2.com as example.
   - On the folder /etc/nginx/conf.d/, create the files app1.com.conf and app2.com.conf
   - Insert the following code inside the files, changing appx for the respective application name
      *      server {
                listen 80 default_server;
                listen [::]:80 default_server;  
                root /var/www/appx.com;  
                index index.html;  
                server_name appx.com www.appx.com;  	
                location / { try_files $uri $uri/ =404;}
            }
   - Create folders to host the webiste files
       - create /var/www/app1.com and /var/www/app2.com
       - Inside the folder add the HTML and static files
   - Run the docker-compose commands and set up the websites
   - Restart nginx with `sudo systemctl restart nginx`
