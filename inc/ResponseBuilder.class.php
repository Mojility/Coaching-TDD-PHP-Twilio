<?php

class ResponseBuilder {
    private $element;

    function __construct() {
        $this->element = new SimpleXMLElement("<Response/>");
    }

    /**
     * @param $group
     * @return string
     */
    function buildForwardToAdministratorsResponse($group) {
        $dialElement = $this->element->addChild("Dial");
        foreach ($group->getAdministrators() as $phone) {
            $dialElement->addChild("Number", $phone);
        }

        $this->element->addChild("Say", "Sorry, nobody could be reached at this time. Please try again later.");

        return $this->element->asXML();
    }

    /**
     * @param $group
     * @param $digits
     * @return string
     */
    function buildDialOutgoingCallResponse($group, $digits) {
        $dialElement = $this->element->addChild("Dial", $digits);
        $dialElement->addAttribute("timeout", 30);
        $dialElement->addAttribute("callerId", $group->getPhone());

        return $this->element->asXML();
    }

    /**
     * @return string
     */
    function buildInvalidDigitsResponse() {
        $this->element->addChild("Say", "You must provide a valid 10-digit phone number to dial.");
        $this->element->addChild("Redirect", SCRIPT_URL);

        return $this->element->asXML();
    }

    /**
     * @return string
     */
    function buildGatherDigitsResponse() {
        $gatherElement = $this->element->addChild("Gather");
        $gatherElement->addAttribute("action", SCRIPT_URL);
        $gatherElement->addAttribute("timeout", 2);

        $gatherElement->addChild("Say", "Enter outgoing number.");

        $pauseElement = $gatherElement->addChild("Pause");
        $pauseElement->addAttribute("length", 8);

        $this->element->addChild("Say", "Sorry, I didn't get your input.");
        $this->element->addChild("Redirect", SCRIPT_URL);

        return $this->element->asXML();
    }

    /**
     * @return mixed
     */
    function buildRejectCallResponse() {
        $this->element->addChild('Reject')->addAttribute("reason", "busy");
        return $this->element->asXML();
    }

}