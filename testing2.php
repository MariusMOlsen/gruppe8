<?php
$target_dir = "/var/www";
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

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
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
<section class="unregistered" id="registrerStudent">
    <h2>Registrer deg som student</h2>
    <form action="registrer/student.php" method="post">
        Navn: <input type="text" name="name"><br>
        E-mail: <input type="email" name="email"><br>
        Passord: <input type="password" name="password"><br>
        Studierettning <input type="text" name="studie"><br>
        Kull: <input type="number" name="kull">
        <input type="submit">
    </form>
</section>
<section class="unregistered" id="registrerForeleser" enctype="multipat/form-data">
    <h2>Registrer deg som foreleser</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</section>
<section class="unregistered" id="login">
    <h2>Log inn her etter å ha registrert deg</h2>
    <form action="login.php" method="post">
        E-mail: <input type="email" name="email">
        Passord: <input type="password" name="password">
        <input type="submit">
    </form>
</section>
</body>
</html>