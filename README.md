# Login as different users for debugging or support

This package enables your users (e.g. administrators or support employees) 
to log into your application as a different user. Finding bugs that only happen 
for a certain user or giving customer support to users without them needing to
share their password becomes a breeze.

## Installation
This package can be installed through Composer.

```
$ composer require ftiersch/chameleon
``` 

If you are using Laravel 5.5 or newer the package will automatically be enabled.

If you are using Laravel 5.4 or older please follow these steps:


### Register the Service Provider
In the file *config/app.php* add the following line to the *providers* array:

```php
...

/*
 * Package Service Providers...
 */
Ftiersch\Chameleon\ChameleonServiceProvider::class,    

...
```


### Register the Impersonate Middleware
To register the middleware that takes care of logging you in as a different user 
you have two choices:


##### Activate the middleware for all routes
To activate the middleware for every route in your application, add it to the 
*web* part of the $middlewareGroups array in the file *app/Http/Kernel.php*:

```php
protected $middlewareGroups = [
    'web' => [
        ...
        \Ftiersch\Chameleon\Middleware\Impersonate::class,
    ],
]
```


##### Activate the middleware only for select routes
To have more control over the routes that will be accessible for this functionality,
register the middleware in the array *$routeMiddleware*:

```php
protected $routeMiddleware = [
    ...
    'impersonate' => \Ftiersch\Chameleon\Middleware\Impersonate::class,
];
```

To activate the chameleon functionality you can enable the middleware in your routes file
like this:

```php
Route::get('/home', 'HomeController@index')->middleware('impersonate');
```


### Add a link to start / stop impersonating someone
Finally, after registering the code, you need a way to choose impersonating someone.
The package will automatically register two named routes for this:

```blade
<a href="{{ route('ftiersch.chameleon.impersonate', ['user' => $user]) }}">
    View the application as {{ $user->name }}
</a>
```

This will print a link with the url to start impersonating the given user. 

If you want to stop the impersonation and return to your own account, use the following route:

```blade
{{ route('ftiersch.chameleon.impersonate.stop') }}
```