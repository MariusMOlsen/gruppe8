<?php
require_once "Console.php";
require_once "DB.php";
include "Cookie.php";

$role = $_COOKIE["role"];
$email = $_COOKIE["email"];
$password = $_POST["password"];
$database = new DB();

try {
    // TODO: Autentisere brukeren
    $changed = $database->changePassword($role, $email, $password);
    echo ($changed);
} catch (Exception $e){
    Console::Log($e);
}


header("Location: http://158.39.188.207/steg1/minSide.php");
//exit;
?>

<a href="login.php">Gå tilbake</a>
