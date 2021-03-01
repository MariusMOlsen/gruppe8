<?php

if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
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
        <h1>Prosjekt tittel 1</h1>
        <section id="registrerStudent">
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
            <form action="registrer/teacher.php" method="post" enctype="multipart/form-data">
                Navn: <input type="text" name="name"><br>
                E-mail: <input type="email" name="email"><br>
                Passord: <input type="password" name="password"><br>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit">
            </form>
        </section>
        <section class="unregistered" id="login">
            <h2>Log inn her etter å ha registrert deg</h2>
            <form action="login.php" method="post">
                E-mail: <input type="email" name="email">
                Passord: <input type="password" name="password">
                <div>
                    <input type="radio" name="role" id="student" value="student">
                    <label for="radio">Student</label>
                    <input type="radio" name="role" id="teacher" value="teacher">
                    <label for="radio">Foreleser</label>
                </div>
                <input type="submit">
            </form>
        </section>
        <section>
            <h2>Print kursrapport</h2>
            <form action="printCourse.php" method="post">
            <div>

                <?php
                require_once "DB.php";
                $db = new DB();
                $allCourses = $db->getAllCourses();

                foreach ($allCourses as $corse){
                    echo '
                            <input type="radio" name="course" value="' . $corse["navn"] . '" >
                            <label for="radio">' . $corse["navn"] . '</label><br>
                            
                        ';
                }
                ?>
            </div>
            <input type="number" maxlength="4" minlength="4" name="pin">
            <input type="submit">
                <p>test</p>
            </form>
        </section>
    </body>
</html>
