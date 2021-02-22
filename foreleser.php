<?php
include_once "Cookie.php";
include_once "Console.php";
include_once "DB.php";
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Prosjekt</title>

        <link rel="stylesheet" href="main.css">

    </head>
    <body>
        <h1>Foreleserside</h1>

        <section id="createSubject">
            <form action="createSubject.php" method="post">
                Navn: <input type="text" name="name"><br>
                pin: <input type="number" name="pin" maxlength="4"><br>
                Emnekode: <input type="text" name="emnekode"><br>
                <input type="submit">
            </form>
        </section>
        <section>
            <h2>Se svar på meldinger</h2>
            <form action="listFeedback.php" method="post">
                <?php
                require_once "DB.php";
                $db = new DB();
                $allCourses = $db->getTeachersCoruses($_COOKIE["email"]);

                foreach ($allCourses as $corse){
                    echo '
                                <input type="radio" name="course" id="' . $corse["navn"] . '" value="' . $corse["navn"] . '" >
                                <label for="radio">' . $corse["navn"] . '</label><br>
                            ';
                }
                ?>
                <input type="submit">
            </form>
        </section>
    </body>
</html>
