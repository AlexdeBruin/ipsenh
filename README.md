# Hoofdfase project - Hogeschool Leiden

## Setup

### Installing modules

Before running `docker-compose up`:

1. `cd docker-hotreload-vue`
2. `npm install`
3. `cd ../docker-hotreload-laravel`
4. `composer install && composer update`

### .env file

Getting a fresh .env file

1. `cd docker-hotreload-laravel/`
2. `cp .env.example .env`
3. Replace the [DB configuration](#db_config)

If app key errors are shown:

1. `cd docker-hotreload-laravel/`
2. `php artisan key:generate`

## Starting the app

In the root directory run:

`docker-compose up`

## <a name="db_config"></a>DB configuration

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=NDLO
DB_USERNAME=NDLO
DB_PASSWORD=password123
```

## Migrating database from Laravel to MySQL.
1. `docker container exec -it ipsenh_laravel_1 php artisan migrate --seed`

## Entering the MySQL database
1. `docker container exec -it ipsenh_mysql_1 mysql -u NDLO -ppassword123`



