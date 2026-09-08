<?
//include alle classes
include "../classes/session.php";
include "../classes/user.php";
include "../classes/connection.php";
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
// kijkt of je alles hebt ingevuld
if (isset($_POST["theme"])) {

    $image = null;

    if (!empty($_FILES["file"]["name"])) {
        $image = $_FILES["file"]["name"];
        // zegt dat de foto naar de upload file moet
        $target = "../upload/" . basename($image);
        // verzet de foto naar de upload file
        move_uploaded_file($_FILES["file"]["tmp_name"], $target);
    }
    // maakt een nieuwe blog aan om toetevoegen aan de database
    $theme = new Theme();
    $theme->name = $_POST["theme"];
    // voegt de blog aan de database
    $theme->insertTheme();

    header("location: ThemePage.php?insert=true");
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

                    <!-- begin form voor de blog maken en daarna toevoegen-->
                    <form method="POST" action="" enctype="multipart/form-data">
                        <h3>Merk</h3>
                        <!-- tekst vak voor het merk-->
                        <input class="form-control" type="text" name="theme" required><br>
                        <!-- de knop om het merk toetevoegen aan de database-->
                        <button type="submit" name="insertPost" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-2">
                    <!--vulling voor de form om het goed in het midden te behouden-->
                </div>
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