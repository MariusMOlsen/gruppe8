<?php
require_once "Console.php";
/*
 * Alt som har med databasen skal i hovedsak ligge her.
 * Metoder som er public skal bare lage SQL statements,
 * som sendes til doSql(), som kontakter databasen.
 *
 * doSql() returnerer et resultatsett for SELECT,
 * true for INSERT og false for feil. I tillegg
 * skrives feil til console
 * */
class DB
{
    public $connection;

    public function authenticate($role, $epost){
        switch ($role){
            case "student":
                $sql = "SELECT * FROM gruppe7.student WHERE epost = '" . $epost . "';";
                break;
            case "teacher":
                $sql = "SELECT * FROM gruppe7.foreleser WHERE epost = '" . $epost . "';";
                break;
            case "admin":
                $sql = "SELECT * FROM gruppe7.admin WHERE epost = '" . $epost . "';";
                break;
            default:
                Console::Log("Finner ikke rollen din");
        }

        $row = $this->doSql($sql);
        $row = $row->fetch_row();
        if($row == null){
            Console::Log("Finner ikke brukeren, har du riktig rolle?");
            return false;
        }
        switch ($role){
            case "student":
                Console::Log($row[5]);
                return $row[5];
            case "teacher":
                Console::Log($row[5]);
                return $row[5];
            case "admin":
                Console::Log($row[4]);
                return $row[4];
            default:
                Console::Log("Finner ikke epost adressen, har du valgt riktig rolle?");
                return false;
        }
    }

    public function createNewStudent($name, $email, $password, $study, $year, $token) {
        $sql = "INSERT INTO gruppe7.student (navn, epost, passord, studierettning, kull, token) VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '" . $study . "', " . $year . ", '" . $token . "');";
        Console::Log("Har laget sql statement");

        return $this->doSql($sql);
    }

    public function createNewTeacher($name, $email, $password, $file, $token){
        $sql = "INSERT INTO gruppe7.foreleser (navn, epost, passord, bildeadresse, token) VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '" . $file  . "', '" . $token . "');";
        Console::Log("Har laget SQL statement");

        $this->doSql($sql);
    }

    public function createSubject($name, $teacher, $code, $pin){
        $sql = "INSERT INTO gruppe7.fag (navn, foreleser, emnekode, pin) VALUES ('" . $name . "', '" . $teacher . "', '" . $code . "', " . $pin . ");";

        return $this->doSql($sql);
    }

    public function checkIfRegistered($role, $email, $password){
        switch ($role){
            case "student":
                $sql = "SELECT passord FROM gruppe7.student WHERE epost LIKE '" . $email . "';";
                break;
            case "teacher":
                $sql = "SELECT passord FROM gruppe7.foreleser WHERE epost LIKE '" . $email . "';";
                break;
            case "admin":
                $sql = "SELECT passord FROM gruppe7.admin WHERE epost LIKE '" . $email . "';";
                break;
            //default:
              //  Console::Log("Finner ikke rollen din");
                //throw new Exception("Finner ikke rollen din");
        }
        $result = $this->doSql($sql);
        if ($result->field_count == 0){
            Console::Log("Finner ikke epost adressen");
            return false;
        }
        $count = 0;
        while ($row = $result->fetch_row()){
            if($row[0] == $password){
                return true;
            }
            $count++;
        }
        Console::Log("Har sjekket " . $count . " brukere i tabellen");
        return false;
    }

    public function getAllCourses(){
        $sql = "SELECT * FROM gruppe7.fag";
        return $this->doSql($sql);
    }

    public function setToken($role, $user, $token) {
        switch($role){
            case "student":
                $sql = "UPDATE gruppe7.student SET token = '" . $token . "' WHERE epost = '" . $user . "';";
                break;
            case "teacher":
                $sql = "UPDATE gruppe7.foreleser SET token = '" . $token . "' WHERE epost = '" . $user . "';";
                break;
            case "admin":
                $sql = "UPDATE gruppe7.admin SET token = '" . $token . "' WHERE epost = '" . $user . "';";
                break;
            default:
                Console::Log("DB finner ikke rollen din");
        }
        return $this->doSql($sql);
    }

    public function changePassword($role, $email, $password) {
        switch ($role){
            case "student":
                $sql = "UPDATE gruppe7.student SET passord = '" . $password . "' WHERE epost = '" . $email . "';";
                break;
            case "teacher":
                $sql = "UPDATE gruppe7.foreleser SET passord = '" . $password . "' WHERE epost = '" . $email . "';";
                break;
            case "admin":
                $sql = "UPDATE gruppe7.admin SET passord = '" . $password . "' WHERE epost = '" . $email . "';";
                break;
            default:
                Console::Log("DB finner ikke rollen din");
        }
        return $this->doSql($sql);
    }

    public function getAllMessages($course, $pinCode){
        $sql = "SELECT pin FROM gruppe7.fag WHERE fag.navn = '" . $course ."';";
        $pin = $this->doSql($sql);
        $pin = $pin->fetch_row();
        $pin = $pin[0];

        if($pin == $pinCode){
            $sql = "SELECT tilbakemelding.kommentar, svar.tekst FROM gruppe7.tilbakemelding 
                    LEFT JOIN gruppe7.svar ON tilbakemelding.fag = svar.fag AND tilbakemelding.student =                     svar.student
                    WHERE tilbakemelding.fag = '" . $course . "';";

            return $this->doSql($sql);
        } else{
            Console::Log("Du har feil PIN kode");
            return false;
        }
    }

    public function giveFeedback($feedback, $coruse, $email, $anonymous) {
        $sql = "INSERT INTO gruppe7.tilbakemelding (kommentar, fag, student, anonym) VALUES ('" . $feedback . "', '" . $coruse . "', '" . $email . "', " . $anonymous . ");";
        $this->doSql($sql);
    }

    public function getImage($teacher){
        $sql = "SELECT bildeadresse FROM gruppe7.foreleser WHERE epost = '" . $teacher . "';";
        $result = $this->doSql($sql);
        $result = $result->fetch_row();


        return $result[0];
    }

    public function getTeachersCoruses($teacher){
        $sql = "SELECT * FROM gruppe7.fag WHERE foreleser = '" . $teacher . "';";
        return $this->doSql($sql);
    }

    public function getFeedback($course){
        $sql = "SELECT * FROM gruppe7.tilbakemelding WHERE fag = '" . $course . "';";
        return $this->doSql($sql);
    }

    public function giveAnswer($text, $course, $student){
        $sql = "INSERT INTO gruppe7.svar (tekst, fag, student) VALUES ('" . $text . "', '" . $course . "', '" . $student . "');";
        $this->doSql($sql);
    }

    public function getName($role, $email){
        switch ($role){
            case "student":
                $sql = "SELECT navn FROM gruppe7.student WHERE epost = '" . $email . "';";
                break;
            case "teacher":
                $sql = "SELECT navn FROM gruppe7.foreleser WHERE epost = '" . $email . "';";
                break;
            case "admin":
                $sql = "SELECT navn FROM gruppe7.admin WHERE epost = '" . $email . "';";
                break;
            default:
                Console::Log("Finner ikke rollen din");
        }
        return $this->doSql($sql);
    }

    // Alt som blir gjort med databasen skjer her
    // TODO: Hindre SQL injection

    private function doSql($sql){
        $conn = mysqli_connect("localhost", "web", "p5794RGF%");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $result = mysqli_query($conn, $sql);

        if (!$result){
            Console::Log($sql . " feilet med feilen " . $result);
            Console::Log(mysqli_error($conn));
//            $conn->close();
            throw new mysqli_sql_exception("SQL feilet");
        } else {
            //$conn->close();
            return $result;
        }
    }
}