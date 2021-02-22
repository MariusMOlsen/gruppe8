<?php
include_once "DB.php";
include_once "Cookie.php";


if (!Cookie::authenticate()){
    header("Location: http://158.39.188.207/steg1/index.php");
    exit("Innlogging godkjent. Går til min side"); }

$database = new DB();

$name = $_POST["name"];
$pin = $_POST["pin"];
$emnekode = $_POST["emnekode"];
$email = $_COOKIE["email"];

$database->createSubject($name,$email,$emnekode,$pin);