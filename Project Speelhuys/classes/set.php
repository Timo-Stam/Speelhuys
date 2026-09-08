<?
class Set
{
    public int $id;
    public string $name;
    public string $description;
    public int $brandId;
    public int $themeId;
    public $image;
    public int $price;
    public int $age;
    public int $pieces;
    public int $stock;

    // de functie om alleblogs op te halen
    public static function findAllSets()
    {
        // connectie met database starten
        $conn = Database::start();
        // vind alle blogs in producten
        $query = "SELECT * FROM sets";
        $result = $conn->query($query);
        //arrey om alle blogs in te doen
        $sets = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //maakt een blog aan voor elke blog
                $set = new Set();
                $set->id = $row['set_id'];
                $set->name = $row['set_name'];
                $set->description = $row['set_description'];
                $set->brandId = $row['set_brand_id'];
                $set->themeId = $row['set_theme_id'];
                $set->image = $row['set_image'];
                $set->price = $row['set_price'];
                $set->age = $row['set_age'];
                $set->pieces = $row['set_pieces'];
                $set->stock = $row['set_stock'];

                // doet de set in de sets array
                $sets[] = $set;
            }
            //retunt alle sets
            $conn->close();
            return $sets;
        } else {
            $conn->close();
            return false;
        }
    }
    // de functie om een specifieken blog tevinden met een blog id
    public static function findSetById($id)
    {
        //connectie database starten
        $conn = Database::start();

        $user = null;

        //veilig maken
        $id = mysqli_real_escape_string($conn, $id);

        //om te zoeken in de database op naam en wachtwoord
        //
        $query = "SELECT * FROM sets 
        WHERE sets_id = '$id'";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            //alle informatie van de gebruiker ophalen
            //
            while ($row = $result->fetch_assoc()) {
                // een nieuw blog aanmaken
                $set = new Set();
                $set->id = $row['set_id'];
                $set->name = $row['set_name'];
                $set->description = $row['set_description'];
                $set->brandId = $row['set_brand_id'];
                $set->themeId = $row['set_theme_id'];
                $set->image = $row['set_image'];
                $set->price = $row['set_price'];
                $set->age = $row['set_age'];
                $set->pieces = $row['set_pieces'];
                $set->stock = $row['set_stock'];
            }
            //terug geven zodat het gebruikt kan worden
            //
            $conn->close();
            //retunt het product
            return $set;
        } else {
            //
            $conn->close();
            return false;
        }
    }
    // de functie om de blog te updaten
    public function updateSet()
    {
        //connectie met de database
        $conn = Database::start();
        // alles veiligmaken
        $id = mysqli_real_escape_string($conn, $this->id);
        $name = mysqli_real_escape_string($conn, $this->name);
        $description = mysqli_real_escape_string($conn, $this->description);
        $brandId = mysqli_real_escape_string($conn, $this->brandId);
        $themeId = mysqli_real_escape_string($conn, $this->themeId);
        $image = mysqli_real_escape_string($conn, $this->image);
        $price = mysqli_real_escape_string($conn, $this->price);
        $age = mysqli_real_escape_string($conn, $this->age);
        $pieces = mysqli_real_escape_string($conn, $this->pieces);
        $stock = mysqli_real_escape_string($conn, $this->stock);
        // de update van de set
        $sql = "
        UPDATE 
            Sets
         SET
            set_name = '" . $name . "',
            set_description = '" . $description . "',
            set_brand_id = '" . $brandId . "',
            set_theme_id = '" . $themeId . "',
            set_image = '" . $image . "',
            set_price = '" . $price . "',
            set_age = '" . $age . "',
            set_pieces = '" . $pieces . "',
            set_stock = '" . $stock . "'
        WHERE
            set_id = " . $id . "
        ";
        $conn->query($sql);
        $conn->close();
    }
    public function insertSet()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $name = mysqli_real_escape_string($conn, $this->name);
        $description = mysqli_real_escape_string($conn, $this->description);
        $brandId = mysqli_real_escape_string($conn, $this->brandId);
        $themeId = mysqli_real_escape_string($conn, $this->themeId);
        $image = mysqli_real_escape_string($conn, $this->image);
        $price = mysqli_real_escape_string($conn, $this->price);
        $age = mysqli_real_escape_string($conn, $this->age);
        $pieces = mysqli_real_escape_string($conn, $this->pieces);
        $stock = mysqli_real_escape_string($conn, $this->stock);
        $sql = "INSERT INTO sets
        (
            set_name,
            set_description,
            set_brand_id,
            set_theme_id ,
            set_image ,
            set_price,
            set_age,
            set_pieces,
            set_stock
        ) VALUES (
            '$name',
            '$description',
            '$brandId',
            '$themeId',
            '$image',
            '$price',
            '$age; ,
            '$pieces',
            '$stock'
        )";
        $conn->query($sql);
        $conn->close();
    }
    public function deleteSet()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "
        DELETE FROM
            sets
        WHERE
            set_id = " . $id . "";

        $conn->query($sql);
        $conn->close();
    }
}