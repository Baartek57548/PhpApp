<?php
namespace App;

class Request
{
    public array $urlParams;
    public array $postParamItems;
    public array $getParamItems;

    private function __construct()
    {
        $this->urlParams = $_SERVER;
        $this->postParamItems = $_POST;
        $this->getParamItems = $_GET;
    }

    static public function initializeRequest(): self
    {
        return new self();
    }
}