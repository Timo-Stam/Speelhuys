<?
class Database
{
    public static function start()
    {
        $dbServername = "127.0.0.1";
        $dbUser = "root";
        $dbPassword = "mysql";
        $dbDatabase = "speelhuys";

        $conn = new mysqli($dbServername, $dbUser, $dbPassword, $dbDatabase);
        if ($conn->connect_error) {
            die("fout door: ". $conn->connect_error);
        }
    return $conn;
    }
}