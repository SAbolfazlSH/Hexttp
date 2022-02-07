<?php

namespace Hexttp;

class Response {
    public $statusCode;
    private $body;
    function __construct($body, $info) {
        $this->body = $body;
        $this->statusCode = $info['http_code'];
    }
    function json() { return json_decode($this->body); }
    function raw() { return $this->body; }
    function isOk() { return $this->statusCode <= 400; }
}