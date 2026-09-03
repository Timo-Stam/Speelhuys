<?
//de user class om de gebruikers te vinden in de database
//
class User
{
    public string $username;
    public string $password;
    public int $id;
    public string $Firstname;
    public string $lastName;
    public string $email;
    public string $role;
    //functie om de gebruiker te vinden doormiddel van een naam en wachtwoord
    public static function findUser($username, $password)
    {
        $conn = Database::start();
        
        $user = null;

        //veilig maken
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        //om te zoeken in de database op naam en wachtwoord
        $query = "SELECT * FROM users 
        WHERE user_username = '$username'
        AND user_password = '$password'";

        $result = $conn->query($query);


        if ($result->num_rows > 0) {

            //alle informatie van de gebruiker ophalen
            while ($row = $result->fetch_assoc()) {
                $user = new user();
                $user->username = $row['user_username'];
                $user->password = $row['user_password'];
                $user->id = $row['user_id'];
                $user->role = $row['user_role'];
            }

            $conn->close();
            return $user;
        } else {
            //als er geen user is gevonden return je een false
            $conn->close();
            return false;
        }
    }
    
    //om een gebruiker te vinden uit de database doormidel van userid
    public static function findAdmin($id)
    {
        $conn = Database::start();
        $user = null;
        //veilig
        $id = mysqli_real_escape_string($conn, $id);
        $user = mysqli_real_escape_string($conn, $user);

        //zoeken in database op userid
        $query = "SELECT * FROM users WHERE user_id = '$id'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //ophalen of de gebruiker admin is en wat de naam is
                $user = new User();
                $user->Firstname = $row['user_firstname'];
                $user->lastName = $row['user_lastname'];
                $user->email = $row['user_email'];
                $user->username = $row ['user_username'];
                $user->password = $row ['user_password'];
                $user->role = $row ['user_role'];
            }
            //terug geven
            $conn->close();
            return $user;
        }
        else{
            $conn->close();
            return false;
        }
    }
}