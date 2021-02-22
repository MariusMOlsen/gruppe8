<?php
include "TokenGenerator.php";
include "DB.php";
include "Cookie.php";

$database = new DB();
//$database->connect();
//$database->steg1();

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$study = $_POST["studie"];
$year = $_POST["kull"];
$token = TokenGenerator::createToken();

try{
    // TODO: Legge til sjekker for at verdiene ikke er null
    // TODO: Hindre SQL injection og sånt
    // TODO: Hashe passord
    // TODO: Nettleseren sier at man blir hacket?
    $sucess = $database->createNewStudent($name, $email, $password, $study, $year, $token);
    Cookie::login($email, $token, "student");
} catch (mysqli_sql_exception $exception){
    echo $exception->getMessage();
}

?>
