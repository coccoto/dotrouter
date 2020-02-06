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

PathParameter is placed in the property because it is inserted into the constructor argument of the loading class.

- app/controllers/FooController.php

```php
namespace app\controllers;

class FooController {

    public array $pathParameter;

    public function __construct(array $pathParameter) {

        $this->pathParameter= $pathParameter;
    }

    public function barMethod() {

        echo $this->pathParameter['page'];
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