# ToDo List (with Burndown Chart) - Laravel 6.2
Basic todo list, that allows users to register, log in, and create tasks that are saved against their account. It includes the dynamic burndown chart, that displays the number of tasks that were not yet completed at each minute in the last hour.
## Installation Steps
**Clone the repo**
```
https://github.com/aginotra/to_do_list.git todolist && cd todolist
```
**Run composer install**
```
composer install
```
**Run npm install**
```
npm install
```
**Create .env**
```
cp .env.example .env
```
**Generate APP_KEY**
```
php artisan key:generate
```

**Configure MySQL connection details in .env**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={database name}
DB_USERNAME={database user}
DB_PASSWORD={database password}
```
**Run database migrations and seeders**
```
php artisan migrate
php artisan db:seed
```
## Running the application
Run the application in a **Virtual Host**

#### Comes with couple of default users
User credentials are as follows
```
Email: admin@example.com | Password: password
```
## PHPUnit Test
To run the unit test, go to the project root and run
```
phpunit
```
