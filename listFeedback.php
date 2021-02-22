<html>
    <body>
        <a href="minSide.php">Gå tilbake til min side</a>
        <form action="giveAnswerToFeedback.php" method="post">
            <?php
            include_once "DB.php";
            $course = $_POST["course"];

            setcookie("course", $course, time() + 100000, "/");

            $database = new DB();
            $feedbacks = $database->getFeedback($course);

            foreach ($feedbacks as $feedback){
                echo '<input type="radio" name="feedback" value="' . $feedback["student"] . '">';
                echo '<label for="radio">' . $feedback["kommentar"] . "</label><br>";
            }
            ?>
            <textarea name="text"></textarea>
            <input type="submit">
        </form>
    </body>
</html>
