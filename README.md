## Features
- REST API
- Role management

- User management

- Account settings 

- Record management

## Tech

- BOOTSRAP 5

- LARAVEL 9

- PHP8


## Requirements

- PHP >= 8.0.0

- PDO PHP Extension

- Mysql 

- Composer >= 2.2.3


# Installation
Just clone the project to anywhere in your computer.
```bash
git https://github.com/mazepamykhailo/home-assignment.git
``` 

Then do a composer require laravel/ui

```bash
composer require laravel/ui
``` 

Then create a environment file using this command

```bash
cp .env.example .env
``` 

```bash
php artisan key:generate
``` 

Then edit .env file with appropriate credential for your database server. Just edit these two parameter(```DB_USERNAME``` , ```DB_PASSWORD``` ).

and

```bash 
php artisan migrate
``` 

```bash
php artisan db:seed 
``` 

Now you are done.

```bash
php artisan serve
``` 
and open the project on the browser.
## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
