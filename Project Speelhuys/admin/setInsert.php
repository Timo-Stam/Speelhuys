<?php
//include alle classes
include "../classes/session.php";
include "../classes/user.php";
include "../classes/connection.php";
include "../classes/set.php";
include "../classes/brand.php";
include "../classes/theme.php";

//check voor de cookie

if (!isset($_COOKIE["speelhuys-project-cookie"])) {
    header("location: index.php?message=Geen cookie gevonden.");
}
// check of de cookie nog geldig is en kijkt of de user wel een admin is

$session = Session::findSession();
$user = User::findAdmin($_GET["id"]);
// check of de cookie en gebruiker wel kloppen en stuurt je anders naar de inlog pagina
if ($session == false) {
    header("location: index.php?Geen session gevonden.");
}
if ($user == null) {
    header("Location: index.php?message=Geen gebruiker gevonden.");
    exit;
}
if ($user->role == null) {
    header("Location: index.php?message=Geen admin.");
    exit;
}

//vind alle themas en merken voor de dropdown
$themes = Theme::findAllThemes();
$brands = Brand::findAllBrands();

// kijkt of je alles hebt ingevuld
if (isset($_POST["insertPost"])) {

    $image = null;

    if (!empty($_FILES["file"]["name"])) {
        $image = $_FILES["file"]["name"];
        // zegt dat de foto naar de upload file moet
        $target = "../upload/" . basename($image);
        // verzet de foto naar de upload file
        move_uploaded_file($_FILES["file"]["tmp_name"], $target);
    }
    // maakt een nieuwe blog aan om toetevoegen aan de database
    $set = new Set();
    $set->name = $_POST["name"];
    $set->description = $_POST["description"];
    $set->brandId = $_POST["brand"];
    $set->themeId = $_POST["theme"];
    $set->price = $_POST["price"];
    $set->age = $_POST["age"];
    $set->pieces = $_POST["pieces"];
    $set->stock = $_POST["stock"];
    $set->image = $image;
    // voegt de blog aan de database
    $set->insertSet();

    header("location: setPage.php?insert=true");
}

?>
<!-- navbar begin -->
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/public.css">
    <link rel="stylesheet" href="../css/jquery-te-1.4.0.css">
</head>
<div class="text-center mt-3">

    <body>
        <!-- de invul textblokken op de startpagina om inteloggen -->
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <!--vulling-->
                </div>
                <nav class="navbar navbar-expand-lg bg-body-tertiary border border-black mb-1">
                    <div class="container-fluid">
                        <!--navbar foto-->
                        <a class="navbar-home" href="../user/overview.php">
                            <img src="../images/image.png" alt="huis" width="50" height="35">
                        </a>
                        <button class="navbar-toggler" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                <a class="nav-link active" href="index.php">
                                    <h5>Inlog pagina</h5>
                                </a>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                <!-- geeft de userid mee om naar de insert tegaan-->
                                <a class="btn admin-nav-link <?= in_array($currentPage, ['setPage.php', 'setInsert.php', 'setEdit.php', 'setDelete.php'], true) ? 'active' : '' ?>"
                                    id="navbarSetsPage" href="setPage.php?id=<?= $session->userId ?>">
                                    <h5>Sets</h5>
                                </a>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <!-- de merk tekst boven aan als button om naar de adminpagina tegaan-->
                            <div class="navbar-nav">
                                <a class="btn admin-nav-link <?= in_array($currentPage, ['brandPage.php', 'brandInsert.php', 'brandEdit.php', 'brandDelete.php'], true) ? 'active' : '' ?>"
                                    id="navbarbrandPage" href="brandPage.php">
                                    <h5>Merk</h5>
                                </a>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <!-- de thema tekst boven aan als button om naar de adminpagina tegaan-->
                            <div class="navbar-nav">
                                <a class="btn admin-nav-link <?= in_array($currentPage, ['themePage.php', 'themeInsert.php', 'themeEdit.php', 'themeDelete.php'], true) ? 'active' : '' ?>"
                                    id="navbarAdminpage" href="themePage.php">
                                    <h5>Thema</h5>
                                </a>
                            </div>
                        </div>
                        <!--verwelkomende tekst voor de admin-->

                        <div class="col-1">
                            <!-- dit is opvulling voor de tekst zodat het in het midden is en niet schuin-->
                        </div>
                    </div>
                </nav>
                <!--eind navbar-->
                <div class="col-2">
                    <!-- dit is voor opmaak van de form -->
                </div>
                <div class="col-5 mt-3">

                    <!-- begin form voor de blog maken en daarna toevoegen-->
                    <form method="POST" action="" enctype="multipart/form-data">
                        <h3>nieuwe set</h3>
                        <!-- tekst vak voor de naam-->
                        <p>Naam</p>
                        <input class="form-control" type="text" name="name" required>
                        <!-- beschrijving tekst -->
                        <p>beschrijving</p>
                        <div class="form-group">
                            <lablel for="content">Inhoud:</lablel><br>
                            <!-- tekst area voor de content-->
                            <textarea class="jqte" id="content" name="description" required></textarea>
                        </div>
                        <!-- dropdown voor merken -->
                        <p>Uw merk</p>

                        <select class="form-select" name="brand" aria-label="Default select example" required>
                            <option value="" selected>Kies uw merk</option>
                            <!--foreach loop om alle merken te laten zien -->
                            <?php foreach ($brands as $brand) { ?>
                                <option value="<?= $brand->id ?>"><?= $brand->name ?></option> <?php
                            }
                            ?>
                        </select>
                        <p>Uw thema</p>
                        <select class="form-select" name="theme" aria-label="Default select example" required>
                            <option value="" selected>Kies uw thema</option>
                            <?php foreach ($themes as $theme) { ?>
                                <option value="<?= $theme->id ?>">
                                    <?= $theme->name ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <!-- tekst vak voor prijs-->
                        <p>Prijs</p>
                        <input class="form-control" type="text" name="price" required>
                        <!-- tekst vak voor de steentjes-->
                        <p>aantal steentjes</p>
                        <input class="form-control" type="text" name="pieces" required>
                        <!-- tekst vak voor de leeftijd-->
                        <p>Leeftijd</p>
                        <input class="form-control" type="text" name="age" required>
                        <!-- tekst vak voor de steentjes-->
                        <p>Vooraad</p>
                        <input class="form-control" type="text" name="stock" required>
                        <!-- de knop om het merk toetevoegen aan de database-->
                        <button type="submit" name="insertPost" class="btn btn-primary">Submit</button>
                </div>
                <!-- om een foto toetevoegen aan de blog-->
                <div class="col-1 mt-5">
                    <h6>Voeg hier uw foto toe.</h6>
                    <input type="file" name="file" class="form-control-file" />
                    <br><br>
                    </form>
                </div>
                <div class="col-2">
                    <!--vulling voor de form om het goed in het midden te behouden-->
                </div>
            </div>
        </div>
        <div>
            <!-- dit is voor de achtergrond-->
            <?php
            $backgroundImage =
                // de achtergrond foto
                '../images/kavowo-paper-3155438.jpg';
            ?>
            <style>
                body {
                    background: #0d1820;
                    background-image: radial-gradient(circle at 21% 45%, rgba(151, 168, 66, 0.4), transparent 30%);
                }
            </style>
        </div>
        <!--java bootstrap code-->
        <script type="text/javascript" src="https://code.jquery.com/jquery.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $('.jqte').jqte();
        </script>

    </body>

</html>