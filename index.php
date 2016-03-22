<?php
require_once("inc/globals.php");
require_once("inc/Group.php");
require_once("inc/ResponseBuilder.php");

define("SCRIPT_URL", "http://myserver.com/phones/index.php");

define("FORWARD_MODE", "forward");
define("REJECT_MODE", "reject_busy");
define("ADMIN_PHONE", "+19055551212");
define("ADMIN2_PHONE", "+14165551212");
define("MEMBER_PHONE", "+17055551212");

$From = $_POST['From'];
//$From = ADMIN_PHONE;
//$From = MEMBER_PHONE;

$Digits = $_POST['Digits'];
//$Digits = "6135551212";
//$Digits = "48424";

$group = new Group();
$responseBuilder = new ResponseBuilder();
$responseBuilder->invoke($group, $From, $Digits);
