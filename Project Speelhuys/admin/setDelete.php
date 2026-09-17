<?php
//include alle classes
include "../classes/session.php";
include "../classes/user.php";
include "../classes/connection.php";
include "../classes/set.php";
include "../classes/brand.php";
include "../classes/theme.php";

// check voor cookie
if (!isset($_COOKIE["speelhuys-project-cookie"])) {
    header("location: index.php?message=Geen cookie gevonden.");
}

//alle informatie uit de database halen
$session = Session::findSession();
$id = $session->userId;
$user = User::findAdmin($id);
$set = Set::findSetById($_GET["id"]);
$brand = Brand::findBrandById($set->brandId);
$theme = Theme::findThemeById($set->themeId);

//check van de dingen die je uit de database haalt en anders wordt je weggestuurd
if ($set == null) {
    header("location: setPage.php?message=Geen merk gevonden.");
}

if ($session == false) {
    header("location: index.php?message=Geen session gevonden.");
}

if ($user == null) {
    header("Location: index.php?message=Geen gebruiker gevonden.");
    exit;
}
if ($user->role != "admin") {
    header("Location: setPage.php?adminCheck=false");
    exit;
}
if (isset($_POST["deleteBtn"])) {
    $set->deleteSet();

    header("Location: setPage.php?delete=true");
    exit;
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
                <!-- dit is de blog met nog een 2de check of er wel een blog bestaat-->
                <?php if ($set) { ?>
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
                                    <h2><?= $set->name ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!--dit zet de titel van de blog neer-->
                                    <h2><?= $set->description ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!-- de foto van de blog-->
                                    <img src="../upload/<?= $set->image ?>" class="img-fluid img-thumbnail"
                                        style="max-height: 200px; max-width: 200;">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!--dit zet de titel van de blog neer-->
                                    <h2><?= $brand->name ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!--dit zet de titel van de blog neer-->
                                    <h2><?= $theme->name ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!--dit zet de titel van de blog neer-->
                                    <h2><?= $set->price ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!--dit zet de titel van de blog neer-->
                                    <h2><?= $set->pieces ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!--dit zet de titel van de blog neer-->
                                    <h2><?= $set->age ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!--dit zet de titel van de blog neer-->
                                    <h2><?= $set->stock ?></h2>
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
                <?php } ?>
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
                    background-image: radial-gradient(circle at 65% 89%, rgba(151, 168, 66, 0.4), transparent 30%);
                }
            </style>
        </div>
        <!-- script voor de tekst area-->
        <div>
            <script type="text/javascript" src="https://code.jquery.com/jquery.min.js" charset="utf-8"></script>
            <script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                $('.jqte').jqte();
            </script>
        </div>
</div>
</body>

</html>