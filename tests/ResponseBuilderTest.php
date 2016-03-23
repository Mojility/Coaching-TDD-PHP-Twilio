<?php

require_once("./inc/ResponseBuilder.php");

class ResponseBuilderTest extends PHPUnit_Framework_TestCase {

    protected $responseBuilder = null;

    function setUp() {
        $this->responseBuilder = new ResponseBuilder();
    }

    function testResponseBuilderExists() {
        $this->assertInstanceOf("ResponseBuilder", $this->responseBuilder);
    }

    function testBuildForwardToAdministratorsResponse() {
        $group = new Group();
        $response = $this->responseBuilder->buildForwardToAdministratorsResponse($group);
        $this->assertXmlStringEqualsXmlString(
            "<Response>
                <Dial>
                    <Number>+19055551212</Number>
                    <Number>+14165551212</Number>
                </Dial>
                <Say>Sorry, nobody could be reached at this time. Please try again later.</Say>
             </Response>",
            $response
        );
    }

    function testBuildDialOutgoingCallResponse() {
        $group = new Group();
        $response = $this->responseBuilder->buildDialOutgoingCallResponse($group, "+17055551212");
        $this->assertXmlStringEqualsXmlString(
            "<Response>
                <Dial timeout='30' callerId='+14085551212'>+17055551212</Dial>
             </Response>",
            $response
        );
    }

    function testBuildInvalidDigitsResponse() {
        $response = $this->responseBuilder->buildInvalidDigitsResponse();
        $this->assertXmlStringEqualsXmlString(
            "<Response>
                <Say>You must provide a valid 10-digit phone number to dial.</Say>
                <Redirect>".SCRIPT_URL."</Redirect>
             </Response>",
            $response
        );
    }

    function testBuildGatherDigitsResponse() {
        $response = $this->responseBuilder->buildGatherDigitsResponse();
        $this->assertXmlStringEqualsXmlString(
            "<Response>
                <Gather action='".SCRIPT_URL."' timeout='2'>
                    <Say>Enter outgoing number.</Say>
                    <Pause length='8'/>
                </Gather>
                <Say>Sorry, I didn't get your input.</Say>
                <Redirect>".SCRIPT_URL."</Redirect>
             </Response>",
            $response
        );
    }

    function testBuildRejectCallResponse() {
        $response = $this->responseBuilder->buildRejectCallResponse();
        $this->assertXmlStringEqualsXmlString(
            "<Response>
                <Reject reason='busy'/>
             </Response>",
            $response
        );
    }
}
