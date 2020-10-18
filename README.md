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
$ cp .env.dev-eojin .env
$ vi .env # set local database connection and your own secret keys & admin credential
$ php artisan migrate
$ php artisan db:seed --class=AddAdminUser
```

### Running Dev Server

If you run [Valet](https://laravel.com/docs/master/valet) (highly recommended) :

```bash
$ cd ../
$ valet secure deccl # typically https://deccl.test
$ valet restart
$ laravel-echo-server start
$ php ./deccl/artisan queue:work
```

Otherwise :

```bash
$ laravel-echo-server start
$ php artisan queue:work
$ php -S localhost:7700 -t public
```

## How to contribute

This repository follows Github Flow.

```bash
$ git pull origin main:main
$ git checkout main
$ git checkout -b feature/awesome-new-feature
$ git add .
$ git commit -m "Awesome New Feature! Please review"
$ git push -u origin feature/awesome-new-feature # and then wait for review
```

## Stacks & Specification

### Stacks

* Lumen Framework 8
    * `withFacades()`, `withEloquent()` enabled
* Bootstrap 4
    * jQuery, popper.js, bootbox, BlockUI, js-cookie included
* Laravel Echo
    * Implementing real-time notifications
    * A home-made service worker to be introduced

### Specification

* Pattern: Conventional MVC with hand written resourceful routes
* Auth: Http-only Cookie and/or HTTP Authorization Bearer header based
    * Token is JWT; IP check to be introduced
* Architecture: Event-driven
    * Everything that happens publicly here is basically queued beforehand

## Code of Conduct

⚠ WARNING : SARCASM AHEAD ⚠

### 1. Make users narcissistic.

Let them be happy with their own opinions and actions. Do not try to change their minds. Encourage them to be the "celebrities."

### 2. Make the entire experience too-easy-and-fun-to-be-healthy.

Give them a good lie that making comments and reactions actually contributes to the world, which alone is *apparently* not.

### 3. Make Quantity matters over quality, frequency over contents.

Your only concern is daily new comments rate, not how empty or toxic or too-many they are.