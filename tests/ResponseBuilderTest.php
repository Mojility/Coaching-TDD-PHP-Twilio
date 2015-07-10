<?php

require_once("./inc/ResponseBuilder.class.php");

class ResponseWriterTest extends PHPUnit_Framework_TestCase {

    protected $responseBuilder = null;

    function setUp() {
        $this->responseBuilder = new ResponseBuilder();
    }

    function testResponseBuilderExists() {
        $this->assertNotNull($this->responseBuilder);
    }

}
