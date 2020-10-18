# deccl

https://deccl.us (TBD)

News Commentors' & Journalism Critics' Playground.

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
    * Cookie (or HTTP Authorization Bearer header) based authorization
    * `withFacades()`, `withEloquent()` enabled
* Bootstrap 4
    * jQuery, popper.js, bootbox, BlockUI, js-cookie included
* Laravel Echo, home-made service worker
    * Implementing real-time notifications

## How to contribute

This repository follows Github Flow.

1. `git pull origin main:main`
2. `git checkout main`
3. `git checkout -b feature/awesome-new-feature`
4. `git add .`
5. `git commit -m "Awesome New Feature! Please accept"`
6. `git push -u origin`
7. (wait for merge)

## Code of Conduct

### 1. Let them talk to themselves.

Let them be happy with their own writings. Get them narcissistic.

### 2. Tell them you can be famous too.

Reward them by the amount of the attention they drag. Produce some "celebrities."

### 3. Make the entire commenting process easy and addictive.

Give a good lie that making comments actually contributes to the world. (Which *apparently* is not)

### 4. Quantity over quality.

Your only concern is daily new comments rate.