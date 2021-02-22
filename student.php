<?php
include_once "Cookie.php";
include_once "DB.php";

?>

<html>

<head>
    <h1>Student side</h1>

    <link rel="stylesheet" href="main.css">
</head>

<body
<section>
    <h2>Fag</h2>
    <form action="giveFeedback.php" method="post">
        <input type="radio" name="anonymous" id="anonymous" value="1">
        <label for="radio">Anonym</label>
        <br>
        <input type="radio" name="anonymous" id="notAnonymous" value="0">
        <label for="radio">Ikke anonym</label>
        <br>
        --------------------
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
        <textarea name="feedback"></textarea>
        <input type="submit">
    </form>
</section>

</body>
</html>
