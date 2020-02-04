# dotrouter

It does a very simple routing.

## Prerequisites

- PHP 7.4

## Installation

```sh
$ composer require coccoto/dotrouter
```

## Usage

```php
require_once 'vendor/autoload.php';

$map = [
    '/' => [
        'controller' => 'Index',
        'method' => 'index',
    ],
];

$namespace = 'app\\controllers\\';

$dotRouter = new coccoto\dotrouter\DotRouter();
$dotRouter->push($map, $namespace);
```

### Set the namespace.

```php
$namespace = 'app\\controllers\\';
```

### Create a routing map.

Path parameters can be used by preceding them with a colon.

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
namespace app\controllers;

class FooController {

    public array $pathParameter;

    public function setPathParameter(array $pathParameter): void {

        $this->pathParameter = $pathParameter;
    }

    public function barMethod() {

        // echo $pathParameter['page'];
    }

    ~~~
}
```

### Perform routing.

There are no more features and it's easy. Then start it.

```php
~~~

$dotRouter = new coccoto\dotrouter\DotRouter();
$dotRouter->push($map, $namespace);
$dotRouter->run();
```

## License
MIT License