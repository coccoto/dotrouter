<?php

namespace coccoto\dotrouter;

final class DotRouter {

    private ? object $request = null;
    private ? array $conf = null;
    private array $pathParameter = [];

    public function __construct() {

        $this->request = new Request();
    }

    public function run(): void {

        foreach ($this->conf['map'] as $request => $order) {
            $this->router($request, $order['controller'], $order['method']);
        }
    }

    private function router(string $request, string $controller, string $method): void {

        $this->request->setMapParameters($request);

        $uriParameters = $this->request->getUriParameters();
        $mapParameters = $this->request->getMapParameters();

        $this->dispatch($uriParameters, $mapParameters, $controller, $method);
    }

    private function dispatch(array $uriParameters, array $mapParameters, string $controller, string $method): void {

        foreach (array_map(null, $uriParameters, $mapParameters) as [$uriParameter, $mapParameter]) {

            if (! ($uriParameter === $mapParameter or strpos($mapParameter, ':') === 0) or $mapParameter === null) {
                return;

            } else if (strpos($mapParameter, ':') === 0) {
                $this->setPathParameter($uriParameter, $mapParameter);
            }
        }

        $this->execute($controller, $method);
    }

    private function execute(string $controller, string $method): void {

        $controllerInstance = $this->createController($controller);
        $controllerInstance->$method();
    }

    private function setPathParameter(string $uriParameter, string $mapParameter): void {

        $parameter = substr($mapParameter, 1);
        $this->pathParameter[$parameter] = $uriParameter;
    }

    private function createController(string $controller): object {

        $controllerName = $this->conf['namespace'] . $controller;
        return new $controllerName($this->pathParameter);
    }

    public function push(array $map, string $namespace): void {

        $this->conf = [
            'map' => $map,
            'namespace' => $namespace,
        ];
    }
}