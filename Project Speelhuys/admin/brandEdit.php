<?php
//include alle classes
include "../classes/session.php";
include "../classes/user.php";
include "../classes/connection.php";
include "../classes/brand.php";
//check voor cookie
if (!isset($_COOKIE["speelhuys-project-cookie"])) {
    header("location: index.php?message=Geen cookie gevonden.");
}
//alles uit de database halen
$session = Session::findSession();
$userId = $session->userId;
$user = User::findAdmin($userId);
$brand = Brand::findBrandById($_GET["id"]);

// check alles uit de database en als er een fout is stuurt het je terug naar inlog pagina
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
// kijkt of je alles hebt ingevuld als je op de knop drukt
if (isset($_POST["name"])) {
    if (!empty($_FILES["file"]["name"])) {
        $brand->image = $_FILES["file"]["name"];
        //verplaats de foto naar upload map
        move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/" . $_FILES["file"]["name"]);
    }
    //post de naam, beschrijving en foto
    ///
    //
    //!
    $brand->name = $_POST["name"];
    //update de blog met de nieuwe aanpassingen
    $brand->updateBrand();
    header("Location: brandPage.php?update=true");
    exit;

}
?>
<!-- navbar begin -->
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
                                <a class="nav-link active" id="navbarSetsPage"
                                    href="setPage.php?id=<?= $session->userId ?>">
                                    <h5>Sets</h5>
                                </a>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <!-- de merk tekst boven aan als button om naar de adminpagina tegaan-->
                            <div class="navbar-nav">
                                <a class="nav-link active" id="navbarbrandPage" href="brandPage.php">
                                    <h5>Merk</h5>
                                </a>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <!-- de thema tekst boven aan als button om naar de adminpagina tegaan-->
                            <div class="navbar-nav">
                                <a class="nav-link active" id="navbarAdminpage" href="themePage.php">
                                    <h5>Thema</h5>
                                </a>
                            </div>
                        </div>
                        <!--verwelkomende tekst voor de admin-->
                        <div class="container text-end">
                            <h4> Welkom tot de website admin</h4>
                        </div>
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

                    <!-- begin form voor het editen van de blog-->
                    <form method="POST" action="" enctype="multipart/form-data">
                        <h3>Merk</h3>
                        <!-- vult de informatie van de blog al automatisch in-->
                        <input class="form-control" type="text" name="name" value="<?= $brand->name ?>" required>
                        <!--  de knop om te editen-->
                        <button type="submit" name="insertPost" class="btn btn-primary">Edit</button>
                </div>
                <!-- de foto toevengen gedeelte-->
                <div class="col-1 mt-5">
                    <h6>Voeg hier uw foto toe.</h6>
                    <input type="file" name="file" class="form-control-file" /><br><br>
                    <!-- pakt de foto uit upload map-->
                    <img src="../upload/<?= $brand->image ?>"
                        style="max-width: 350px; max-height: 350px; display: block;">
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
                    background-image: url('<?php echo $backgroundImage; ?>');
                    background-size: cover;
                }
            </style>
        </div>
    </body>

</html>