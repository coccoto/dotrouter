# dotrouter

It does a very simple routing.

## Prerequisites

- PHP 7.4

## Installation

```sh
$ composer require coccoto/routing
```

## Usage

```php
require_once 'vendor/autoload.php';

$dotRouter = new coccoto\dotrouter\DotRouter();
```

### Set the namespace.

- src/conf/namespace.php

```php
$namespace = 'controllers\\';
```

### Create a routing map.

Path parameters can be used by preceding them with a colon.

- src/conf/map.php

```php
$map = [
    '/' => [
        'controller' => 'Index', // IndexController
        'method' => 'index', // indexMethod
    ],
    '/foo/page/:page' => [
        'controller' => 'Foo', // FooController
        'method' => 'bar', // barMethod
    ],
];
```

### Create a class to load.

Creates a specified namespace for the class to be loaded, a property called path Parameter, and a method called setPathParameter.

- app/controllers/FooController.php

```php
namespace controllers;

class FooController {

    public array $pathParameters;

    public function setPathParameters(array $pathParameter): void {

        $this->pathParameter = $pathParameter;
    }

    public function barMethod() {

        // echo $pathParameters['page'];
    }

    ~~~
}
```

### Perform routing.

There are no more features and it's easy. Then start it.

```php
~~~

$dotRouter = new coccoto\dotrouter\DotRouter();
$dotRouter->run();
```

## License
MIT License