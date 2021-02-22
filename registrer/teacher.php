<?php
include "../TokenGenerator.php";
include "../DB.php";
include "../Cookie.php";

$database = new DB();

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$file = $_POST["picture"];
$file2 = $_FILES;


// henter bildet
$target_dir = '/var/www/gruppe7/bilder/';
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}



// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}



var_dump($file);
echo "<br>";
var_dump($file2);

$pictureName = TokenGenerator::createToken();
$token = TokenGenerator::createToken();

try{
    // TODO: Legge til sjekker for at verdiene ikke er null
    // TODO: Hashe passord
    // TODO: Nettleseren sier at man blir hacket?
    $sucess = $database->createNewTeacher($name, $email, $password, $target_file, $token);
    Cookie::login($email, $token, "teacher");
} catch (mysqli_sql_exception $exception){
    echo $exception->getMessage();
}




echo "</p>";
echo '<pre>';
echo 'Here is some more debugging info:';
print_r($_FILES);
print "</pre>";

header("Location: http://158.39.188.208/gruppe7/minSide.php");
exit("Bruker registrert. Går til min side");
?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prosjekt</title>

    <link rel="stylesheet" href="../main.css">

</head>
<body>
<h1>Bilde</h1><br><br>
<img src="/img/baby.jpg" alt="baby" width="42px" height="69px">


</body>
</html>
