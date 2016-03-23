<?php
require_once("inc/globals.php");
require_once("inc/Group.php");
require_once("inc/ResponseBuilder.php");

$group = new Group();

if (FORWARD_MODE == $group->getMode()) {

    if (!$group->isAdministrator($_POST['From'])) {

        $response = "<Response>\n";
        $response .= "<Dial>\n";
        foreach($group->getAdministrators() as $phone) {
            $response .= "<Number>$phone</Number>\n";
        }
        $response .= "</Dial>\n";
        $response .= "<Say>Sorry, nobody could be reached at this time. Please try again later.</Say>\n";
        $response .= "</Response>\n";
        echo $response;

    } else {

        if ($_POST['Digits']) {

            if (10 == strlen($_POST['Digits'])) {

                $response = "<Response>\n";
                $response .= "<Dial";
                $response .= ' timeout="30"';
                $response .= ' callerId="' . $group->getPhone() . '"';
                $response .= ">". $_POST['Digits'] ."</Dial>\n";
                $response .= "</Response>\n";
                echo $response;

            } else {

                $response = "<Response>\n";
                $response .= "<Say>You must provide a valid 10-digit phone number to dial</Say>\n";
                $response .= "<Redirect>" . SCRIPT_URL . "</Redirect>\n";
                $response .= "</Response>\n";
                echo $response;

            }

        } else {

            $response = "<Response>\n";
            $response .= "<Gather";
            $response .= ' action="' . SCRIPT_URL . '"';
            $response .= ' timeout="2"';
            $response .= ">\n";
            $response .= "<Say>Enter outgoing number.</Say>\n";
            $response .= "<Pause length=\"8\"/>\n";
            $response .= "</Gather>\n";
            $response .= "<Say>Sorry, I didn't get your input.</Say>\n";
            $response .= "<Redirect>" . SCRIPT_URL . "</Redirect>\n";
            $response .= "</Response>\n";
            echo $response;

        }

    }

} else {

    $response = new SimpleXMLElement("<Response/>");
    $response->addChild('Reject')->addAttribute("reason", "busy");
    echo $response->asXML();

}
