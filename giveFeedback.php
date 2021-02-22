<?php
include "DB.php";

$anonymous = $_POST["anonymous"];
$coruse = $_POST["course"];
$feedback = $_POST["feedback"];

$database = new DB();
$database->giveFeedback($feedback, $coruse, $_COOKIE["email"], $anonymous);
