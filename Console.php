<?php


class Console
{
    public static function Log($message){
        echo ("
            <script type=\"text/javascript\">
            console.log(\"" . $message . "\")
            </script>");
    }
}