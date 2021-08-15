# Laravel Page Cache
[![Latest Stable Version][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![License][ico-license]](LICENSE.txt)

This package allows you to easily cache responses as static files on disk for lightning fast page loads.

- [Introduction](#introduction)
- [Installation](#installation)
    - [Middleware](#middleware)
- [Config](#config)
- [Usage](#usage)

This package can cache static PHP page on local disk to provide a fast loading of pages

## Introduction
It would be a heavy loading if lots of visitors plus the page loading lots of content from database with lots of logic
Page cache can reduce the loading.

## installation
1) Install package with composer:
```
$ composer require label-li/laravel-page-cache
```

2) Publish the config to `config/pagecache.config`
```php
php artisan vendor:publish --provider="LabelLi\LaravelPageCache\PageCacheServiceProvider"
```

### Middleware
> If you want to cache all route in middleware `web`, i.e., all http traffics:
1) Open `app/Http/Kernel.php`
2) Copy `\LabelLi\LaravelPageCache\Middleware\CacheResponse::class,` as a new line to the `web` middleware group:

```php
protected $middlewareGroups = [
    'web' => [
        \LabelLi\LaravelPageCache\Middleware\CacheResponse::class,
        ...
    ],
];
```

> If you want to cache specific route `page-cache`:
1) Open `app/Http/Kernel.php`
2) Copy `'page-cache' => \LabelLi\LaravelPageCache\Middleware\CacheResponse::class,` as a new line to the `$routeMiddleware`:

```php
protected $routeMiddleware = [
    'page-cache' => \LabelLi\LaravelPageCache\Middleware\CacheResponse::class,
    ...
];
```

## Config
Change the value in `config/pagecache.php` to what you want:
```php
'CacheTime' => 3600, // In seconds
'CachePath' => 'pagecache', // In storage
```


## Usage

### Using the middleware

> If you choose to cache specific route, e.g. `page-cache`, use the `page-cache` middleware as follow:

```php
Route::middleware('page-cache')->get('/page', 'PageController@show');
```

`/page` will be cached to a file under the `storage/**$CachePath**` directory.


### Clearing the cache

The cache will be cleared with the `CacheTime` set in `config/pagecache.php`.
It is default 3600s.

If you want to clear it manually, please run the following command

```
php artisan PageCache:clear
```

You may optionally pass a URL slug to the command, to only delete the cache for a specific page:

```
php artisan PageCache:clear {slug}
```

To clear everything under a given path, use the `--recursive` flag:

```
php artisan PageCache:clear {slug} --recursive
```


[ico-downloads]: https://poser.pugx.org/label-li/laravel-page-cache/downloads
[ico-license]: https://poser.pugx.org/label-li/laravel-page-cache/license
[ico-version]: https://poser.pugx.org/label-li/laravel-page-cache/v/stable

[link-downloads]: https://packagist.org/packages/label-li/laravel-page-cache
[link-packagist]: https://packagist.org/packages/label-li/laravel-page-cache