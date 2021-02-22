<?php
require_once "Console.php";
require_once "DB.php";
include "TokenGenerator.php";
include "Cookie.php";

$database = new DB();
$email = $_POST["email"];
$password = $_POST["password"];
$role = $_POST["role"];




$sucsess = $database->checkIfRegistered($role, $email, $password);
if ($sucsess){
    //Console::Log("Du er nå logget inn");
    $token = TokenGenerator::createToken();
    Cookie::login($email, $token, $role);
    $database->setToken($role, $email, $token);


    header("Location: http://158.39.188.207/steg1/minSide.php");
    exit("Innlogging godkjent. Går til min side");

} else {
    Console::Log("Innloggingen feilet");
    header("Location: http://158.39.188.207/steg1/index.php");
    exit("Innlogging feilet. Går til hovedside.");
}

