<?php
class Session
{
    public int $id;
    public int $userId;
    public string $key;
    public string $start;
    public string $end;

    //insert functie om de blog toetevoegen
    public function insert()
    {
        $conn = Database::start();
        $sql = "INSERT INTO sessions
        (
            session_user_id,
            session_key,
            session_start,
            session_end
        ) VALUES (
            '" . $this->userId . "',
            '" . $this->key . "' ,
            '" . $this->start . "' ,
            '" . $this->end . "' 
        )";
        //pakt de value van het object en voegt die toe op de bij behorende plekken

        $conn->query($sql);
        $conn->close();
    }

    // om de sessie te vinden in de database doormiddel van de cookie
    public static function findSession()
    {
        $conn = Database::start();
        $session = null;

        if (isset($_COOKIE['speelhuys-project-cookie'])) {
            $key = mysqli_real_escape_string($conn, $_COOKIE["speelhuys-project-cookie"]);
            
            // kijkt naar of de key hetzelfde is en of de sessie nog geldig is
            $query = "SELECT * FROM sessions
            WHERE session_key = '" . $key . "' AND session_end > '" . date("Y-m-d H:i:s") . "'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $session = new Session();
                $session->id = $row['session_id'];
                $session->userId = $row['session_user_id'];
                $session->key = $row['session_key'];
                $session->start = $row['session_start'];
                $session->end = $row['session_end'];

            }
            $conn->close();
            return $session;
        } else {
            return false;
        }
    }
}