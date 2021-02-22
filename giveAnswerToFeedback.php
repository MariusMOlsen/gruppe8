<?php
include_once "DB.php";

$text = $_POST["text"];
$student = $_POST["feedback"];
$course = $_COOKIE["course"];

$database = new DB();
$database->giveAnswer($text, $course, $student);
