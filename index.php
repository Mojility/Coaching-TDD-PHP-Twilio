<?php
require_once("inc/globals.php");
require_once("inc/Group.php");
require_once("inc/Dispatcher.php");

//$From = $_POST['From'];
//$From = ADMIN_PHONE;
$From = MEMBER_PHONE;

//$Digits = $_POST['Digits'];
//$Digits = "6135551212";
$Digits = "48424";

$group = new Group();
$dispatcher = new Dispatcher();
echo $dispatcher->invoke($group, $From, $Digits);
