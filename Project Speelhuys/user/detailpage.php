<?php

include "../classes/connection.php";
include "../classes/set.php";
include "../classes/brand.php";
include "../classes/theme.php";

$set = Set::findSetById($_GET['id']);

if ($set == false) {
    header("location: overview.php?message=Geen set gevonden.");
    exit;
}

$brand = Brand::findBrandById($set->brandId);
$theme = $set->themeId ? Theme::findThemeById($set->themeId) : null;

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/public.css">
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

                <div class="text-start mt-2">
                    <a href="overview.php" class="btn btn-secondary btn-sm back-btn">Terug</a>
                </div>

                <div class="col-4 mt-3">
                    <img src="../upload/<?= $set->image; ?>" alt="<?= $set->name; ?>" align="left"
                        style="max-width: 100%; height: auto; margin-right: 20px;">
                </div>

                <div class="col-4 mt-3">
                    <div class="info-box">
                        <p><strong><?= $set->name; ?></strong></p>
                    </div>
                    <div class="info-box">
                        <p><strong>Merk</strong>: <?= $brand ? $brand->name : 'Onbekend'; ?></p>
                    </div>
                    <div class="info-box">
                        <p><strong>Thema</strong>: <?= $theme ? $theme->name : 'Geen thema'; ?></p>
                    </div>
                    <div class="info-box">
                        <p><strong>Leeftijd</strong>: <?= $set->age; ?></p>
                    </div>
                    <div class="info-box">
                        <p><strong>Prijs</strong>: €<?= $set->price; ?></p>
                    </div>
                    <div class="info-box">
                        <p><strong>Aantal blokken</strong>: <?= $set->pieces; ?></p>
                    </div>
                    <div class="info-box">
                        <p><strong>Beschrijving</strong>: <?= $set->description; ?></p>
                    </div>
                    <div class="info-box">
                        <p><strong>Voorraad</strong>: <?= $set->stock > 0 ? $set->stock : 'Niet beschikbaar'; ?></p>
                    </div>
                </div>

                <style>
                    body {
                        background: #0d1820;
                        background-image: radial-gradient(circle at 100% 1%, rgba(151, 168, 66, 0.4), transparent 30%);
                    }
                </style>
    </body>

</html>