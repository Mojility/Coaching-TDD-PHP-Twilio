<?php
require_once("inc/Group.class.php");
require_once("inc/ResponseBuilder.class.php");

define("SCRIPT_URL", "http://myserver.com/phones/index.php");

//$From = $_POST['From'];
//$From = ADMIN_PHONE;
$From = MEMBER_PHONE;

//$Digits = $_POST['Digits'];
//$Digits = "6135551212";
//$Digits = "48424";
$Digits = null;

$group = new Group(FORWARD_MODE);
$builder = new ResponseBuilder();

if (FORWARD_MODE == $group->getMode()) {
    if (!$group->isAdministrator($From)) {
        $response = $builder->buildForwardToAdministratorsResponse($group);
    } else {
        if ($Digits) {
            if (10 == strlen($Digits)) {
                $response = $builder->buildDialOutgoingCallResponse($group, $Digits);
            } else {
                $response = $builder->buildInvalidDigitsResponse();
            }
        } else {
            $response = $builder->buildGatherDigitsResponse();
        }
    }
} else {
    $response = $builder->buildRejectCallResponse();
}

echo $response;
