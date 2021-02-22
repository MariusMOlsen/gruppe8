<?php

include_once "Cookie.php";

if($_COOKIE["user"]) {
    $loggedIn = Cookie::authenticate();

    if ($loggedIn) {
        Console::Log("Velkommen " . $_COOKIE["email"] . " du er logget inn som en " . $_COOKIE["role"]);
    } else {
        Console::Log("Velkommen, hvem du nå enn er");
    }
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prosjekt</title>

    <link rel="stylesheet" href="main.css">



</head>
<body>
<h1>Prosjekt tittel</h1><br><br>

<section class="unregistered" id="registrerForeleser" enctype="multipat/form-data">
    <h2>Registrer deg som foreleser</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>

</section>



</body>
</html>