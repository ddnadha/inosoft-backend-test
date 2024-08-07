## Project for back-end dev entrance test at PT. Inosoft Trans Sistem

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

### How to Install

1. Install Dependecies via composer

    > composer install --ignore-platform-reqs

2. Change database host to "localhost"

3. Create database 'inorctest' for main apps and 'inorctest-unittest' for test environment

4. Set .env and .env.test file, make sure database configuration is set correctly

5. Seed data

    > php artisan db:seed

6. Run the test

    > php artisan test

7. If all the test run perfectly, you may serve the app now
    > php artisan serve

### API Docs

#### Auth

**1. POST - /api/register**
body with value of name, email and password are required for this endpoint

```
   {
       "name" : "User",
       "email" : "user@gmail.com",
       "password" : "12345678"
   }
```

**2. POST - /api/login**
body with value of email and password are required for this endpoint

```
   {
       "email" : "user@gmail.com",
       "password" : "12345678"
   }
```

#### Transaction

for this section, bearer token are required for each request to placed in the headers.

```
"Authorization" : "Bearer token"
```

**1. GET - /api/transaction**
get all transaction that stored in database

**1. POST - /api/transaction**
create new transaction, body with certain value are required, exmaple:

```
    {
      "nama" :"john",
      "harga" : 100000000,
      "item" : {
                  [
                      // change id with generated id in your own database
                      "id"  : "66b25726dbb0aa7fc3034b86",
                      "qty" : 3
                  ],
                  [
                      "id" : '66b25647388e1130b4061426',
                      "qyt" : 3
                  ]
            }
    }
```
