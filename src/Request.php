<?php

namespace coccoto\dotrouter;

final class Request {

    private ? array $uriParameters = null;
    private ? array $mapParameters = null;

    public function __construct() {

        $this->setUriParameters($_SERVER['REQUEST_URI']);
    }

    public function getUriParameters(): array {

        return $this->uriParameters;
    }

    public function getMapParameters(): array {

        return $this->mapParameters;
    }

    private function setUriParameters(string $request): void {

        $this->uriParameters = $this->separate($request);
    }

    public function setMapParameters(string $request): void {

        $this->mapParameters = $this->separate($request);
    }

    private function separate(string $request): array {

        $parameters = explode('/', $request);
        return array_slice($parameters, 1);
    }
}