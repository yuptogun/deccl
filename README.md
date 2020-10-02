# deccl

https://deccl.us

News Commentors' & Journalism Critics' Playground

## Quick Start

### Requirements

* PHP 7.4^ + Composer
* MySQL
* Redis
* Node.js + npm
* Laravel Echo Server (`npm i -g laravel-echo-server`)

### Installation

```bash
$ composer install
$ npm install
```

### Running Server

```bash
$ laravel-echo-server start
$ php artisan queue:work
$ php -S localhost:7700 -t public
```

## Stacks & Specification

* Lumen Framework 8
    * Cookie based authorization
    * `withFacades()`, `withEloquent()` enabled
    * Basically it should have been developed as a Laravel app
* Bootstrap 4
    * jQuery, popper.js, bootbox, BlockUI, js-cookie included
* Laravel Echo, home-made service worker
    * Implementing real-time notifications

## Keep it in mind...

### 1. Let them talk to themselves.

Let them be happy with their own writings. Get them narcissistic.

### 2. Tell them you can be famous too.

Reward them by the amount of the attention they drag. Produce some "celebrities."

### 3. Make the entire commenting process easy and addictive.

Give a good lie that making comments actually contributes to the world. (Which *apparently* is not)

### 4. Quantity over quality.

Your only concern is daily new comments rate.