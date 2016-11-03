# Links
### Links statistics for laravel 5

[![StyleCI](https://styleci.io/repos/72780598/shield?branch=master)](https://styleci.io/repos/72780598)
![StyleCI](https://img.shields.io/badge/Built_for-Laravel-green.svg?style=flat-square)
![StyleCI](https://img.shields.io/github/license/consoletvs/links.svg?style=flat-square)


![Links Logo](http://i.imgur.com/tWlribC.png)

![Sample 1](https://i.gyazo.com/7ec31509b21f392ff93b1b4339a001c9.png)

![Sample 2](https://i.gyazo.com/faa9a5b99a816d366348a6f85826602b.png)

![Sample 3](https://i.gyazo.com/51d0f03789670f7d31cc4cceead62ab5.png)

![Sample 4](https://i.gyazo.com/fbdc7fdc83ca27cf3818ad2c4479f893.png)

## Table Of Contents

-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Usage](#usage)

# Installation

To install charts use composer

### Download

```
composer require consoletvs/links
```

### Add service provider & alias

Add the following service provider to the array in: ```config/app.php```

```php
ConsoleTVs\Links\LinksServiceProvider::class,
```

Add the following alias to the array in: ```config/app.php```

```php
'Links' => ConsoleTVs\Links\Facades\Links::class,
```
### Publish the assets

```
php artisan vendor:publish
```

### Migrate

```
php artisan migrate
```
# Configuration

## Default Settings

The file in: ```config/links.php``` contains an array of settings, you can find the default settings in there.

```php
<?php

return [
    /* Middleware that will be applied to the statistic pages */
    'middleware' => ConsoleTVs\Links\Middleware\LinksMiddleware::class,

    /* Password to use if ConsoleTVs\Links\Middleware\LinksMiddleware is beeing used */
    'password' => 'LinksRocks',

    /* The views layout */
    'layout' => 'links::template',

    /* The route prefix, will be applied to all of the routes. */
    'prefix' => 'links',
];
```

You should now modify the password if you're willing to use the default middleware.


### The Middleware

The middleware is applied to the statistics page, this middleware can be changed and you're able to apply your own access rules.

*Default:* ```ConsoleTVs\Links\Middleware\LinksMiddleware::class```

The default middleware requires a simple password to login.

### The Password (Only with the default middleware)

The password needs to be set if you are using the default middleware. This will allow you to login.

*Default:* ```LinksRocks```

### The Layout

The layout can be changed, but the current pages are designed using **Bootstrap 4** keep that in mind.

*Default:* ```links::template```

### The prefix

The prefix will be used in all of the routes. It determines the root of all the routes of the package.

*Default:* ```links```

# Usage

## Create Links

To create links, go in the view where you want to add a traked link and instead of using the typical url operations:

```php
{{ url('http://google.com') }}
{{ route('google') }}
```

Use the package facade:

```php
{{ Links::url('http://google.com') }}
{{ Links::route('google') }}
```

## Track Pages

if you want to track down the current page, simply do this:

**Note:** It uses jQuery!

```php
// If jQuery .js is already included and you don't want conflits:
{!! Links::track() !!}

// If jQuery .js is not included in your view, this will also add it.
{!! Links::track(true) !!}
```

**Quick tip:** Adding the track to the views layout will track all pages using that layout once visited!

## View the statistics

To view all the links statistics go to the root of the package (the prefix).
The default prefix is: ```links```.

Once you are inside the links app. You'll need to login if you're using the default mdiddleware.
The default password is: ```LinksRocks```

Once you're in the web app, you're ready to explore the statistics.
