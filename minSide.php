<?php
include_once "Cookie.php";
include_once "DB.php";
$loggedIn = Cookie::authenticate();

if ($loggedIn){
    Console::Log("Du er logget inn");
} else {
    Console::Log("Du er ikke logget inn");
}
$database = new DB();
//$role = $_COOKIE("role");
//$email = $_COOKIE("email");

$img = $database->getImage($_COOKIE["email"]);

//$name = $database->getName($role,$email);

var_dump($img)

?>

<html>
<head>

</head>
<body>
<header>
    <h1>Min side</h1>

    <h2>Velkommen:  </h2>
    <img src="<?php echo $img ?>">
</header>
<section>
    <h2>Bytt passord</h2>
    <form action="changepass.php" method="post">
        Nytt passord: <input type="password" name="password">
        <input type="submit">
    </form>
</section>
<?php if($_COOKIE["role"] == "student"){
    include "student.php";
} elseif ($_COOKIE["role"] == "teacher"){
    include "foreleser.php";
} elseif ($_COOKIE["role"] == "admin"){
    include "admin.php";
} else {
    echo "Noe har skjært seg";
}
?>
</body>
</html>
