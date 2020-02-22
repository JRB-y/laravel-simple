<p align="center"><img src="https://i.ibb.co/mSchBwq/Untitled-1.jpg"></p>

**<p align="center"> Boost your laravel workflow with SIMPLE and useful tiny packages</p>**


## Installation

1 - To install Simple:

```shell
composer require jrb/simple
```

2 - If you use Laravel +5.0 no need to register the Service Provider, else you need 
to register it manually. <br>
In `config/app.php` add the provider:

```php
Jrb\Simple\SimpleServiceProvider::class
```

3 - To use `simple:crud` you need to publish the stubs.

```shell
php artisan vendor:publish --tag=simple-crud
```
Laravel will publish the crud stubs to `/resources/views/stubs`.

## Usage
For now you have only the simple crud generator.

```shello
php artisan simple:crud Post [options]
```
This command will generate 4 files: 
- Post.php
- PostController.php
- PostRequest.php
- create_posts_table.php

## Want to share with us?

Great! We are open for any suggestion :)