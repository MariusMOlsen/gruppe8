<?php
include_once "DB.php";

$database = new DB();

$course = $_POST["course"];
$pin = $_POST["pin"];

$result = ($database->getAllMessages($course, $pin));

foreach ($result as $row){
    echo $row["kommentar"] . "  --   " . $row["text"] . "<br>";
}