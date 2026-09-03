<?
//include alle classes
include "../classes/session.php";
include "../classes/user.php";
include "../classes/connection.php";
include "../classes/brand.php";

// check voor cookie
if (!isset($_COOKIE["speelhuys-project-cookie"])) {
    header("location: index.php?message=Geen cookie gevonden.");
}

//alle informatie uit de database halen
$session = Session::findSession();
$id = $session->userId;
$user = User::findAdmin($id);
$brand = Brand::findBrandById($_GET["id"]);

//check van de dingen die je uit de database haalt en anders wordt je weggestuurd
if ($brand == null) {
    header("location: ../overview.php");
}

if ($session == false) {
    header("location: index.php?message=Geen session gevonden.");
}

if ($user == null) {
    header("Location: index.php?message=Geen gebruiker gevonden.");
    exit;
}
if ($user->admin != 1) {
    header("Location: index.php?message=Geen admin.");
    exit;
}
if (isset($_POST["deleteBtn"])) {
    $product->deleteProduct();

    header("Location: admin.php?delete=true");
    exit;
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
                <!-- begin navbar-->
                <nav class="navbar navbar-expand-lg bg-body-tertiary border border-black mb-1">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="../user/overview.php">
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
                                <a class="nav-link active" id="navbarBlogMakingPage"
                                    href="insert.php?id=<?= $session->userId ?>">
                                    <h5>maak nieuw blog</h5>
                                </a>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                <a class="nav-link active" id="navbarAdminpage" href="admin.php">
                                    <h5>Admin</h5>
                                </a>
                            </div>
                        </div>
                        <div class="container text-end">
                            <h4> Welkom tot de website admin</h4>
                        </div>
                        <div class="col-1">
                            <!-- dit is opvulling voor de tekst zodat het in het midden is en niet schuin-->
                        </div>
                    </div>
                </nav>
                <!-- eind navbar -->
                <!-- dit is de blog met nog een 2de check of er wel een blog bestaat-->
                <? if ($brand) { ?>
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
                                    <!--dit zet de titel van de blog neer-->
                                    <h2><?= $brand->title ?></h2>
                                </td>
                            <tr>
                                <td>
                                    <h5><?= $brand->content ?></h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5><?= $brand->author ?></h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!-- de foto van de blog-->
                                    <img src="../upload/<?= $brand->image ?>" class="img-fluid img-thumbnail"
                                        style="max-height: 400px; max-width: 400;">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!-- de button om de blog teverwijderen-->
                                    <form method="POST" name="delete">
                                        <button type="submit" name="deleteBtn">
                                            <p>Delete</p>
                                        </button>
                                    </form>
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