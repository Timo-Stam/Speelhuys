<?php
require_once "../classes/connection.php";
require_once "../classes/brand.php";
require_once "../classes/theme.php";
require_once "../classes/set.php";

$brands = Brand::findAllBrands();
$themes = Theme::findAllThemes();

$keywords = $_GET['keywords'] ?? '';
$merk = $_GET['merk'] ?? '';
$thema = $_GET['thema'] ?? '';
$prijs = $_GET['prijs'] ?? '';
$leeftijd = $_GET['leeftijd'] ?? '';

$perPagina = 8;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$startPagina = ($pagina - 1) * $perPagina;

$sets = Set::search($keywords, $merk, $thema, $prijs, $leeftijd, $perPagina, $startPagina);

$totalResults = Set::searchCount(
    $keywords,
    $merk,
    $thema,
    $leeftijd
);

$totalPages = ceil($totalResults / $perPagina);

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


                <?php foreach ($sets as $set) { ?>

    <div class="col-3 mt-3">
        <div class="card mx-auto h-100" style="width: 18rem min height: 500px;">

            <div class="embed-responsive embed-responsive-1by1">
                <img src="../upload/<?= $set->image ?>"
                    class="card-img-top embed-responsive-item"
                    style="object-fit: contain; height: 18rem;"
                    alt="<?= $set->name ?>">
            </div>

            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= $set->name ?></h5>

                <p class="card-text" style="height:90px; overflow: hidden;">
                    <?= $set->description ?>
                </p>

                <p class="card-text">
                    €<?= $set->price ?>
                </p>

                <a href="../user/detailpage.php?id=<?= $set->id ?>"
                    class="btn btn-primary mt-auto">
                    Bekijk product
                </a>
            </div>

        </div>
    </div>


    
    <?php } ?>
    
    <nav>
    <ul class="pagination justify-content-center">
    
        <?php if ($pagina > 1) { ?>
            <li class="page-item">
                <a class="page-link"
                   href="?<?= http_build_query([
                       'keywords' => $keywords,
                       'merk' => $merk,
                       'thema' => $thema,
                       'prijs' => $prijs,
                       'leeftijd' => $leeftijd,
                       'pagina' => $pagina - 1
                   ]) ?>">
                    Vorige
                </a>
            </li>
        <?php } ?>
    
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
    
            <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                <a class="page-link"
                   href="?<?= http_build_query([
                       'keywords' => $keywords,
                       'merk' => $merk,
                       'thema' => $thema,
                       'prijs' => $prijs,
                       'leeftijd' => $leeftijd,
                       'pagina' => $i
                   ]) ?>">
                    <?= $i ?>
                </a>
            </li>
    
        <?php } ?>
    
        <?php if ($pagina < $totalPages) { ?>
            <li class="page-item">
                <a class="page-link"
                   href="?<?= http_build_query([
                       'keywords' => $keywords,
                       'merk' => $merk,
                       'thema' => $thema,
                       'prijs' => $prijs,
                       'leeftijd' => $leeftijd,
                       'pagina' => $pagina + 1
                   ]) ?>">
                    Volgende
                </a>
            </li>
        <?php } ?>
    
    </ul>
    </nav>
    
</div>
</div>
<div>
                <!-- dit is voor de achtergrond-->
                <?php
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