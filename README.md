# AnnotationRouter
A wrapper for nikic/fast-route which automatically generates routes from annotations.

## Usage
```php
<?php

$dispatcher = FastRoute\cachedDispatcher(function(\AnnotationRoute\RouteCollector $collector) {
    $collector
        ->addRoutesForClass('Some\\Fully\\Qualified\\Classname')
        ->addRoutesInPathWithNamespace('src', 'Namespace');
}, [
    'routeCollector' => '\\AnnotationRoute\\RouteCollector',
    'cacheFile'      => 'path/to/cache.file',
]);

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri        = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $params  = $routeInfo[2];
        // call $handler with $params
        break;
}
```
It is recommended to only use the AnnotationRouter with a cachedDispatcher since it is relatively expensive to parse the doc comments for route definitions.
