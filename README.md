# HeyTutor Senior Backend Engineer Challenge 

## This is a simple PHP Laravel application to exhibits abilities such as designing a system, routes with specific objectives, complex SQL queries, and the ability to learn new things

### Stack Used
- Docker
    - PHP 8.2 <br>
    - Composer 2.5.8
    - Laravel 10.21
    - PHPUnit 10.3.2
    - Mysql 8.0.20
    - Nginx 1.25.2
      
### How to run the project
- Install Docker and Docker-compose
    - [On Windows](https://docs.docker.com/desktop/install/windows-install/)
    - [On Linux](https://docs.docker.com/desktop/install/linux-install/)
    - [On Mac](https://docs.docker.com/desktop/install/mac-install/)
    
    - This documentation is for downloading the docker desktop that reduces the time spent on complex setups so you can focus on the code

- Make sure that ports 8000 and 3308 are not being used by other processes/programs, as these are the default ports for the code application and the MySQL database, respectively

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
    - After all these steps, your application will be ready and running on localhost:8000
        - In case you see yourself getting an exception `The stream or file "/storage/logs/laravel.log" could not be opened in append mode: failed to open stream: Permission denied`, run `docker exec store chown -R www-data storage` to add the permission

    - PHPUnit  
      - To run all the tests, just open the terminal on the project folder and run `docker exec store ./vendor/bin/phpunit`

## How to access the endpoints
   - Now that the application is running, you can access the endpoints directly on the browser or using an api test tool like [postman](https://www.postman.com/) or [insomnia](https://insomnia.rest/) accessing http://localhost:8000/<b>endpoint</b> <br>

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
    
- About the query
    - The logic behind it: To get the user and their most expensive purchase, <br>
      we need to select the user name, and his higher purchase using the MAX function <br>
      from the table user joins the orders table to get the total amount of information. <br>
      Then we group by user.id so we get only one row per user and order it on desc order. <br>
      I added a currency on select to as I believe in a production environment it would be important information <br>
    - On eloquent:
        - User::select('users.name', DB::raw('MAX(orders.total_amount) as mostExpensivePurchase, "usd" as currency'),) <br>
        ->join('orders', 'users.id', '=', 'orders.user_id')<br>
        ->groupBy('users.id')<br>
        ->orderBy('mostExpensivePurchase', 'desc')<br>
        ->get();<br>
    - On raw MySQL:
        - SELECT users.name, MAX(orders.total_amount) AS mostExpensivePurchase, 'usd' AS currency <br>
          FROM users <br>
          INNER JOIN orders ON users.id = orders.user_id <br>
          GROUP BY users.id <br>
          ORDER BY mostExpensivePurchase DESC <br>
          
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


  - About the query
    - The logic behind it: The objective here is to see the users that have on the orders table, a row with every ID present on the product. <br>
      We select only the name of the user from the table users joining both orders and products table <br>
      grouping by user.id and use a having statement to see if all the distinct IDs present on the user select match <br>
      the number of rows on the table products. If the number matches, the user has all the products on its order <br>
      at least one time <br>
    - On eloquent:
        - User::select('users.name') <br>
        ->join('orders', 'users.id', '=', 'orders.user_id') <br>
        ->join('products', 'orders.product_id', '=', 'products.id') <br>
        ->groupBy('users.id') <br>
        ->havingRaw('COUNT(DISTINCT products.id) = (select COUNT(id) FROM products)') <br>
        ->get(); <br>
    - On raw MySQL:
        - SELECT users.name <br>
          FROM users <br>
          INNER JOIN orders ON users.id = orders.user_id <br>
          INNER JOIN products ON orders.product_id = products.id <br>
          GROUP BY users.id <br>
          HAVING COUNT(DISTINCT products.id) = (SELECT COUNT(id) FROM products) <br>
          
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

- About the query
    - The logic behind it: The objective here is to retrieve the highest sum of total_amount value on the table orders and get all the users where their
      sum of total_amount matches it.
      We begin selecting the name, totalOrderValues (sum of total_amount), and the currency (for the reason I cited on the endpoint1) from the table users
      joining the orders table grouping by user.id and user.name and adding a having clause where the totalOrderValues matches the highest sum of
      total_amount value on the table orders. In this way, we'll bring the user (or users if more of them have the same amount of total)
        
    - On eloquent:
        - User::select('users.name', DB::raw('SUM(orders.total_amount) as totalOrderValue, "usd" as currency')) <br>
        ->join('orders', 'users.id', '=', 'orders.user_id') <br>
        ->groupBy('users.id', 'users.name') <br>
        ->havingRaw('totalOrderValue = (SELECT SUM(o.total_amount) FROM users u JOIN orders o ON u.id = o.user_id GROUP BY u.id ORDER BY SUM(o.total_amount) DESC LIMIT 1)') <br>
        ->get(); <br>
    - On raw MySQL:
        - SELECT users.name, SUM(orders.total_amount) AS totalOrderValue, 'usd' AS currency <br>
            FROM users <br>
            INNER JOIN orders ON users.id = orders.user_id <br>
            GROUP BY users.id , users.name <br>
            HAVING totalOrderValue = <br>
              (SELECT SUM(o.total_amount) <br>
                  FROM users u <br>
                  JOIN orders o ON u.id = o.user_id <br>
                  GROUP BY u.id <br>
                  ORDER BY SUM(o.total_amount) DESC LIMIT 1) <br>


### Bonus - multiple instances of application inside nginx
   - On the root folder of Nginx, edit the nginx.conf and add the code `include /etc/nginx/conf.d/*.conf;` so it can find any .conf file that we create
   - Suppose we want to host app1.com and app2.com as examples.
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
   - On this file, you can also add another param inside the server brackets, the [worker_connections](https://nginx.org/en/docs/ngx_core_module.html#worker_connections), that represents the maximum of connections each worker can handle
   - On websites with higher traffic, you may get a “worker connections not enough” error. This can be fixed by increasing the param, for example, `worker_connections 2048;`
   - The max worker connections are defined by the amount of memory available on the server
   - We can also alter the [worker_process](https://nginx.org/en/docs/ngx_core_module.html#worker_processes), each capable of processing a large number of simultaneous connections
   - The number of NGINX worker processes (the default is 1). In most cases, running one worker process per CPU core works well, and we recommend setting this directive to auto to achieve that. There are times when you may want to increase this number, such as when the worker processes have to do a lot of disk I/O.
   - Create folders to host the website files
       - create /var/www/app1.com and /var/www/app2.com
       - Inside the folder add the HTML and static files
   - Run the docker-compose commands and set up the websites
   - Restart nginx with `sudo systemctl restart nginx`
   - References:
       - https://nginx.org/en/docs/ngx_core_module.html#worker_connections 
       - https://nginx.org/en/docs/ngx_core_module.html#worker_processes
       - https://ubiq.co/tech-blog/configure-multiple-host-names-nginx/
       - https://www.learnbestcoding.com/post/15/hosting-multiple-websites-with-nginx
       - https://www.youtube.com/watch?v=IrWFXrWAvXg&t=1s&ab_channel=Programmingin24h
       - https://www.youtube.com/watch?v=LFrBmvgamGI&t=211s&ab_channel=AndrewSchmelyun 
