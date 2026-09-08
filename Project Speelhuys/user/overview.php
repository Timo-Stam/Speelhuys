<?php
require_once "../classes/connection.php";
require_once "../classes/brand.php";
require_once "../classes/theme.php";

$brands = Brand::findAllBrands();
$themes = Theme::findAllThemes();

$db = Database::start();

$keywords = $_GET['keywords'] ?? '';
$merk = $_GET['merk'] ?? '';
$thema = $_GET['thema'] ?? '';
$prijs = $_GET['prijs'] ?? '';
$leeftijd = $_GET['leeftijd'] ?? '';

$sql = "SELECT sets.*
FROM sets
JOIN brands ON sets.set_brand_id = brands.brand_id
LEFT JOIN themes on sets.set_theme_id = themes.theme_id
WHERE sets.set_name LIKE ?";

$search = "%" . $keywords . "%";

$params = [$search];
$types = "s";
if ($merk !== '') {
    $sql .= " AND brands.brand_name = ?";
    $params[] = $merk;
    $types .= "s";
}
if ($thema !== '') {
    $sql .= " AND themes.theme_name = ?";
    $params[] = $thema;
    $types .= "s";
}


if ($leeftijd === '0-3') {
    $sql .= " AND sets.set_age BETWEEN 0 AND 3";
    }
    if ($leeftijd === '4-6') {
    $sql .= " AND sets.set_age BETWEEN 4 AND 6";
}
if ($leeftijd === '7-9') {
    $sql .= " AND sets.set_age BETWEEN 7 AND 9";
    }
    if ($leeftijd === '10-12') {
        $sql .= " AND sets.set_age BETWEEN 10 AND 12";
        }
        if ($leeftijd === '13+') {
            $sql .= " AND sets.set_age >= 13";
            }
            
if ($prijs === 'laag') {
      $sql .= " ORDER BY sets.set_price ASC";
 }
 if ($prijs === 'hoog') {
    $sql .= " ORDER BY sets.set_price DESC";
 }

 $stmt = $db->prepare($sql);

$bindParams = [$types];

foreach ($params as $key => $value) {
    $bindParams[] = &$params[$key];
}

call_user_func_array([$stmt, 'bind_param'], $bindParams);

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<div class="text-center mt-3">

    <body>
        <!-- de invul textblokken op de startpagina om inteloggen -->
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <!--vulling-->
                </div>
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="../user/overview.php">
                            <img src="../images/image.png" alt="huis" width="50" height="35">
                        </a>
                        <button class="navbar-toggler" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                <a class="nav-link active" href="../admin/index.php">
                                    <h5>Inlog pagina</h5>
                                </a>
                            </div>
                        </div>
                        <div class="container text-end">
                            <h4> Welkom tot de website gebruiker</h4>
                        </div>
                        <div class="col-1">
                            <!-- dit is opvulling voor de tekst zodat het in het midden is en niet schuin-->
                        </div>
                    </div>
                </nav>
                <!-- eind navbar -->

                <form style="text-align:right;" method="get" action="overview.php">
                    <label>
                        search
                        <input type="text" name="keywords" autocomplete="off">
                    </label>
                    <select name="merk">
                        <option value="">Alle merken</option>
                        <option value="lego">Lego</option>
                        <option value="kapla">Kapla</option>
                        <option value="duplo">Duplo</option>
                        <option value="robotime">Robotime</option>
                        <option value="smartmax">SmartMax</option>
                        <option value="brio">Brio</option>
                        <option value="playmobil">Playmobil</option>
                        <option value="megabloks">Megabloks</option>
                        <option value="megaconstrux">MegaConstrux</option>
                        <option value="geomag">Geomag</option>
                        <option value="knex">KNEX</option>
                        <option value="gravitrax">GraviTrax</option>
                        <option value="clementoni">Clementoni</option>
                    </select>
                    <select name="thema">
                        <option value="">Alle thema's</option>
                        <option value="Lego City">Lego City</option>
                        <option value="Lego Marvel">Lego Marvel</option>
                        <option value="Lego Friends">Lego Friends</option>
                        <option value="Lego Architecture">Lego Architecture</option>
                    </select>
                    <select name="prijs">
                        <option value="">Alle prijzen</option>
                        <option value="laag">Laag naar hoog</option>
                        <option value="hoog">Hoog naar laag</option>
                    </select>
                    <select name="leeftijd">
                        <option value="">Alle leeftijden</option>
                        <option value="0-3">0-3 jaar</option>
                        <option value="4-6">4-6 jaar</option>
                        <option value="7-9">7-9 jaar</option>
                        <option value="10-12">10-12 jaar</option>
                        <option value="13+">13+ jaar</option>
                    </select>
                    <input type="submit" value="search"><br>
                </form>


                <?php while ($row = $result->fetch_assoc()) { ?>

    <div class="col-3 mt-3">
        <div class="card mx-auto h-100" style="width: 18rem min height: 500px;">

            <div class="embed-responsive embed-responsive-1by1">
                <img src="../upload/<?= $row['set_image'] ?>"
                    class="card-img-top embed-responsive-item"
                    style="object-fit: cover; height: 18rem;"
                    alt="<?= $row['set_name'] ?>">
            </div>

            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= $row['set_name'] ?></h5>

                <p class="card-text" style="height:90px; overflow: hidden;">
                    <?= $row['set_description'] ?>
                </p>

                <p class="card-text">
                    €<?= $row['set_price'] ?>
                </p>

                <a href="../user/detailpage.php?id=<?= $row['set_id'] ?>"
                    class="btn btn-primary mt-auto">
                    Bekijk product
                </a>
            </div>

        </div>
    </div>

<?php } ?>


            </div>
        </div>
        <div>
            <!-- dit is voor de achtergrond-->
            <?
            $backgroundImage =
                // De achtergrond foto
                '../images/sand-2005066_1280.jpg';
            ?>
            <style>
                body {
                    background-image: url('<?php echo $backgroundImage; ?>');
                    background-size: cover;
                }
            </style>
        </div>
    </body>

</html>