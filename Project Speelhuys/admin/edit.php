<?
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
if ($user->admin != 1) {
    header("Location: index.php?message=Geen admin.");
    exit;
}
// kijkt of je alles hebt ingevuld als je op de knop drukt
if (isset($_POST["title"]) && isset($_POST["content"])) {
    if (!empty($_FILES["file"]["name"])) {
        $brand->image = $_FILES["file"]["name"];
        //verplaats de foto naar upload map
        move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/" . $_FILES["file"]["name"]);
    }
    //post de titel en tekst erin
    ///
    //
    //!
    $brand->name = $_POST["name"];
    //update de blog met de nieuwe aanpassingen
    $brand->updateBrand();
    header("Location: admin.php?update=true");
    exit;

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form</title>
    <link rel="stylesheet" href="../css/jquery-te-1.4.0.css">
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
                <!--begin navbar-->
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
                                <a class="nav-link active" href="insert.php?id=<?= $session->userId ?>" id="navbarBlogMakingPage">
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
                <div class="col-2">
                    <!-- dit is voor opmaak van de form -->
                </div>
                <div class="col-5 mt-3">

                <!-- begin form voor het editen van de blog-->
                    <h4>Blog</h4>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <h6>Titel</h6>
                        <!-- vult de informatie van de blog al automatisch in-->
                        <input class="form-control" type="text" name="title" value="<?= $brand->name ?>" required>
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

        <!-- de script voor de tekstblok-->
        <script type="text/javascript" src="https://code.jquery.com/jquery.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $('.jqte').jqte();
        </script>
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