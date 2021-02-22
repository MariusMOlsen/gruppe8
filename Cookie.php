<?php
include_once "DB.php";
include_once "Console.php";

class Cookie
{
    public static function login($email, $token, $role){

        setcookie("email", $email, time() + (60 * 60), "/");
        setcookie("token", $token, time() + (60 * 60), "/");
        setcookie("role", $role, time() + (60 * 60), "/");
    }

    public static function authenticate(){
        $database = new DB();
        $token = $database->authenticate($_COOKIE["role"], $_COOKIE["email"]);
        if($token == $_COOKIE["token"]){
            return true;
        } else {
            return false;
        }
    }
}