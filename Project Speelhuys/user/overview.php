<?
include "../classes/connection.php";
include "../classes/brand.php";
include "../classes/theme.php";

$brands = Brand::findAllBrands();
$themes = Theme::findAllThemes();

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
                <? if ($brands) {
                    foreach ($brands as $brand) { ?>
                        <div class="col-3 mt-3">
                            <div class="card mx-auto" style="width: 18rem;">
                                <div class="embed-responsive embed-responsive-1by1">
                                    <img src="../upload/<?= $brand->image ?>" class="card-img-top embed-responsive-item"
                                        style="object-fit: cover; height: 18rem;" alt="foto">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $brand->name ?></h5>
                                    <a href="../user/detailpage.php?id=<?= $brand->id ?>" class="btn btn-primary">Zie brand</a>
                                </div>
                            </div>
                        </div>
                        <br>
                    <? }
                } ?>

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