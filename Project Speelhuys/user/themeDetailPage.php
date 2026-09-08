<?
include "../classes/connection.php";
include "../classes/theme.php";


//pakt de blog id uit de url
$theme = Theme::findThemeById($_GET["id"]);
if ($theme == null) {
    header("location: overview.php?message=geen blog gevonden");
}
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
                        <a class="navbar-theme" href="../user/overview.php">
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
                <!--check voor of er een blog is-->
                <? if ($theme) { ?>
                    <div class="col-4">
                        <!-- dit is opmaak voor de bard met infomatie zodat het in het midden is-->
                    </div>
                    <div class="col-4 mt-3">
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    <h6>De titel</h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2><?= $theme->title ?></h2>
                                </td>
                            <tr>
                                <td>
                                    <h5><?= $theme->content ?></h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5><?= $theme->author ?></h5>
                                </td>
                            </tr>
                        </table>
                    </div>
                <? } ?>
            </div>
        </div>
        <div>
            <!-- dit is voor de achtergrond-->
            <?
            $backgroundImage =
                // de achtergrond foto
                '../images/kavowo-paper-3155438.jpg';
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