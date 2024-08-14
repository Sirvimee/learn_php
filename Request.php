<?php

class Request {

    private array $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function param($key) {
        return $this->request[$key] ?? '';
    }

}
