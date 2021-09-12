# laravel-user-loan-api

[![Packagist](https://img.shields.io/packagist/v/kennethtomagan/laravel-6-api-boilerplate.svg)](https://packagist.org/packages/kennethtomagan/laravel-6-api-boilerplate)
[![Packagist](https://poser.pugx.org/kennethtomagan/laravel-6-api-boilerplate/d/total.svg)](https://packagist.org/packages/kennethtomagan/laravel-6-api-boilerplate)
[![Packagist](https://img.shields.io/packagist/l/kennethtomagan/laravel-6-api-boilerplate.svg)](https://packagist.org/packages/kennethtomagan/laravel-6-api-boilerplate)

This is a basic sample for writing Restful API projects using Laravel with requirement:

- Build a simple API that allows to handle user loans.
- Necessary entities will have to be (but not limited to): users, loans, and repayments.
- The API should allow simple use cases, which include (but are not limited to): creating a new
user, creating a new loan for a user, with different attributes (e.g. duration, repayment
frequency, interest rate, arrangement fee, etc.), and allowing a user to make repayments for
the loan.
- The app logic should figure out and not allow obvious errors. For example a user cannot
make a repayment for a loan that’s already been prepaid

##### Packages:

* Laravel Passport - [laravel/passport](https://github.com/laravel/passport)
* Laravel-CORS [barryvdh/laravel-cors](http://github.com/barryvdh/laravel-cors)

##### Require:
* PHP: ^7.4
* MySql: v8.0.23

## Features

* Passport authentication
* Basic features: Registration, Login create Loan, create Transaction for repayment
* JSON API Format response.
* Unit/Feature Testing.

## Installation

#### Install Dependencies

```
$ composer install
```

#### Configure the Environment
Create `.env` file:
```
$ cat .env.example > .env
```
Run `php artisan key:generate`

#### Migrate and Seed the Database
```
$ php artisan migrate:fresh --seed
```

#### Setup Passport
```
$ php artisan passport:install
```

#### Run Test
```
$ php artisan test
```

## API Documentation
* Postman API Documentation is in `User_Loan_API.postman_collection.json`

