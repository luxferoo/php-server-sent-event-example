# php-server-sent-event-example 

JS/PHP chat app using MySQL , Server-sent events & EventSource  + MVC architecture
![screen-capture (1)](https://user-images.githubusercontent.com/17208637/91446718-b68e1480-e86f-11ea-8c62-aa22f91dc83c.gif)


### Setup
1 - Run the following command to create vendor & autoload file (you need to have composer installed or use composer.phar)
```
 $ composer dump-autoload
```
2 - go under config/db.php and configure your database 
```php
$db_dsn = isset($_ENV['DB_DSN']) ? $_ENV['DB_DSN'] : "mysql:host=localhost;dbname=chatdb;";
$db_user = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : "root";
$db_password = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : null;
```

3 - A DB file named (chatDb) is also present in the root project so you can setup the DB

### Start the application

To start the project go to the root project with a terminal and run

```
php -S 127.0.0.1:8000 -t public
```
