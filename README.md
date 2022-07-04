## Getting Started

These instructions will get you a copy of the project up and running on your local machine.

### Prerequisites

Install the Vue CLI.
https://cli.vuejs.org/guide/installation.html

Laravel Requirements. https://laravel.com/docs/8.x

### Installing

Clone this repository

```
git clone https://github.com/Belub/todo-vuejs.git
```

Create a MySQL database

```
mysql> CREATE DATABASE vuetodo;
```

Rename .env.example to .env
```
mv .env.example .env
```

Replace these values in .env
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=laraapp
DB_USERNAME=*************
DB_PASSWORD=*************
```

Generate an application key
```
php artisan key:generate
```

Run the command in main directory

```
composer install
php artisan migrate
npm i 
npm run dev
```
or
```
npm run init-project
```

And start

```
php artisan server
```