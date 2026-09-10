<?php
class Theme
{
    public int $id;
    public string $name;

    // de functie om alleblogs op te halen
    public static function findAllThemes()
    {
        // connectie met database starten
        $conn = Database::start();
        // vind alle blogs in producten
        $query = "SELECT * FROM themes";
        $result = $conn->query($query);
        //arrey om alle blogs in te doen
        $themes = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //maakt een blog aan voor elke blog
                $theme = new Theme();
                $theme->id = $row['theme_id'];
                $theme->name = $row['theme_name'];
                // doet de brand in de brand array
                $themes[] = $theme;
            }
            //retunt alle brands
            $conn->close();
            return $themes;
        } else {
            $conn->close();
            return false;
        }
    }
    // de functie om een specifieken blog tevinden met een blog id
    public static function findThemeById($id)
    {
        //connectie database starten
        $conn = Database::start();

        $user = null;

        //veilig maken
        $username = mysqli_real_escape_string($conn, $id);

        //om te zoeken in de database op naam en wachtwoord
        //
        $query = "SELECT * FROM themes 
        WHERE theme_id = '$id'";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            //alle informatie van de gebruiker ophalen
            //
            while ($row = $result->fetch_assoc()) {
                // een nieuw blog aanmaken
                $theme = new Theme();
                $theme->id = $row['theme_id'];
                $theme->name = $row['theme_name'];
            }
            //terug geven zodat het gebruikt kan worden
            //
            $conn->close();
            //retunt het product
            return $theme;
        } else {
            //
            $conn->close();
            return false;
        }
    }
    // de functie om de blog te updaten
    public function updateTheme()
    {
        //connectie met de database
        $conn = Database::start();
        // alles veiligmaken
        $id = mysqli_real_escape_string($conn, $this->id);
        $name = mysqli_real_escape_string($conn, $this->name);
        // de update van de brand
        $sql = "
        UPDATE 
            themes
         SET
            theme_name = '" . $name . "'
        WHERE
            theme_id = " . $id . "
        ";
        $conn->query($sql);
        $conn->close();
    }
    public function insertTheme()
    {
        $conn = Database::start();

        $name = mysqli_real_escape_string($conn, $this->name);

        $sql = "INSERT INTO themes
        (
            theme_name
        ) VALUES (
            '$name'
        )";
        $conn->query($sql);
        $conn->close();
    }
    public function deleteTheme()
    {
        $conn = Database::start();
        
        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "
        DELETE FROM
            themes
        WHERE
            theme_id = " . $id . "";

        $conn->query($sql);
        $conn->close();
    }
}