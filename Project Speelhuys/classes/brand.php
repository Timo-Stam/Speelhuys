<?
class Brand
{
    public int $id;
    public string $name;
    public $image;

    // de functie om alleblogs op te halen
    public static function findAllBrands()
    {
        // connectie met database starten
        $conn = Database::start();
        // vind alle blogs in producten
        $query = "SELECT * FROM brands";
        $result = $conn->query($query);
        //arrey om alle blogs in te doen
        $brands = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //maakt een blog aan voor elke blog
                $brand = new Brand();
                $brand->id = $row['brand_id'];
                $brand->name = $row['brand_name'];
                $brand->image = $row['brand_logo'];
                // doet de brand in de brand array
                $brands[] = $brand;
            }
            //retunt alle brands
            $conn->close();
            return $brands;
        } else {
            $conn->close();
            return false;
        }
    }
    // de functie om een specifieken blog tevinden met een blog id
    public static function findBrandById($id)
    {
        //connectie database starten
        $conn = Database::start();

        $user = null;

        //veilig maken
        $username = mysqli_real_escape_string($conn, $id);

        //om te zoeken in de database op naam en wachtwoord
        //
        $query = "SELECT * FROM brand 
        WHERE brand_id = '$id'";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            //alle informatie van de gebruiker ophalen
            //
            while ($row = $result->fetch_assoc()) {
                // een nieuw blog aanmaken
                $brand = new Brand();
                $brand->id = $row['brand_id'];
                $brand->name = $row['brand_name'];
                $brand->image = $row['brand_logo'];
            }
            //terug geven zodat het gebruikt kan worden
            //
            $conn->close();
            //retunt het product
            return $brand;
        } else {
            //
            $conn->close();
            return false;
        }
    }
    // de functie om de blog te updaten
    public function updateBrand()
    {
        //connectie met de database
        $conn = Database::start();
        // alles veiligmaken
        $id = mysqli_real_escape_string($conn, $this->id);
        $name = mysqli_real_escape_string($conn, $this->name);
        $image = mysqli_real_escape_string($conn, $this->image);
        // de update van de brand
        $sql = "
        UPDATE 
            brands
         SET
            brand_name = '" . $name . "',
            brand_logo = '" . $image . "'
        WHERE
            brand_id = " . $id . "
        ";
        $conn->query($sql);
        $conn->close();
    }
    public function insertBrand()
    {
        $conn = Database::start();

        $name = mysqli_real_escape_string($conn, $this->name);
        $image = mysqli_real_escape_string($conn, $this->image);

        $sql = "INSERT INTO brands
        (
            brand_name,
            brand_logo
        ) VALUES (
            '$name',
            '$image'
        )";
        $conn->query($sql);
        $conn->close();
    }
    public function deleteBrand()
    {
        $conn = Database::start();
        
        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "
        DELETE FROM
            brands
        WHERE
            brand_id = " . $id . "";

        $conn->query($sql);
        $conn->close();
    }
}