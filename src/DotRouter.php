<?php

namespace coccoto\dotrouter;

use coccoto\filereader as filereader;

final class DotRouter {

    private ? object $fileReader = null;
    private ? object $request = null;
    private ? array $conf = null;
    private ? array $pathParameters = null;

    public function __construct() {

        $this->fileReader = new filereader\FileReader();
        $this->request = new Request();

        $this->setConf();
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
                $this->setPathParameters($uriParameter, $mapParameter);
            }
        }

        $this->execute($controller, $method);
    }

    private function execute(string $controller, string $method): void {

        $controllerInstance = $this->createController($controller);
        $methodName = $method . 'Method';

        $controllerInstance->setPathParameters($this->pathParameters);
        $controllerInstance->$methodName();
    }

    private function setPathParameters(string $uriParameter, string $mapParameter): void {

        $parameter = substr($mapParameter, 1);
        $this->pathParameters[$parameter] = $uriParameter;
    }

    private function createController(string $controller): object {

        $controllerName = $this->conf['namespace'] . $controller . 'Controller';
        return new $controllerName;
    }

    private function setConf(): void {

        $conf = $this->fileReader->search(__DIR__ . '/../conf/*');
        $this->conf = $conf;
    }
}