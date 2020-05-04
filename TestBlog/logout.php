<?php
require_once("includes/functions.php"); 
require_once("includes/DB.php");
?>
<?php
require_once("includes/sessons.php");
?>
<?php

$_SESSION["User_Id"]=null;
$_SESSION["Username"]=null;
$_SESSION["AdminName"]=null;
$_SESSION["TrackingURL"]=null;
session_destroy();
Redirect_to("login.php");
?>