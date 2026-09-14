<?php
// include alle classes
include "../classes/session.php";
include "../classes/user.php";
include "../classes/connection.php";
include "../classes/theme.php";

// check voor cookie
if (!isset($_COOKIE["speelhuys-project-cookie"])) {
    header("location: index.php?message=Geen cookie");
}
// alle gegevens ophalen uit de database
$conn = Database::start();
$session = Session::findSession();
$userId = $session->userId;
$user = User::findAdmin($userId);
$themes = Theme::findAllThemes();
// check om zeker te zijn anders wordt je weggestuurd

if ($session == false) {
    header("location: index.php?message=Geen sessie");
}
if ($user == null) {
    header("Location: index.php?message=Geen user");
    exit;
}
if ($user->role == null) {
    header("Location: index.php?message=Geen admin");
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
                                <a class="nav-link active" id="navbarBlogMakingPage"
                                    href="setPage.php?id=<?= $session->userId ?>">
                                    <h5>Sets</h5>
                                </a>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <!-- de merk tekst boven aan als button om naar de adminpagina tegaan-->
                            <div class="navbar-nav">
                                <a class="nav-link active" id="navbarAdminpage" href="brandPage.php">
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
                <!-- alle checks voor de contole bars-->
                <!--ckeck om te kijken of je net iets hebt geupdate voor een controle bar-->
                <?php
                if (isset($_GET["update"])) {
                    ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <!-- voor het symbol-->
                        <svg class="bi flex-shrink-0 me-2 " role="img" aria-label="Success: <symbol id=" check-circle-fill"
                            viewBox="0 0 16 16" width="50" height="35">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <!--tekst in de bar-->
                        <div>
                            <p>Uw blog is geupdate</p>
                        </div>
                    </div>
                <?php }
                //alert check om aantegeven dat je geen admin bent
                if (isset($_GET["adminCheck"])) {
                    ?>
                    <!-- foto in alert wilt niet werken -->

                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" class="mr-2" viewBox="0 0 16 16"
                            fill="currentColor">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                        <div>
                            <p>U bent geen admin</p>
                        </div>
                    </div>
                <?php }
                // checkt of je net wat hebt gedelete en geeft je confermatie daarvan
                if (isset($_GET["delete"])) {
                    ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <!-- voor het symbol-->
                        <svg class="bi flex-shrink-0 me-2 " role="img" aria-label="Success: <symbol id=" check-circle-fill"
                            viewBox="0 0 16 16" width="50" height="35">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <!-- tekst in de controle bar-->
                        <div>
                            <p>Uw blog is gedelete</p>
                        </div>
                    </div>
                <?php }
                // checkt of je net wat hebt gedelete en geeft je confermatie daarvan
                if (isset($_GET["insert"])) {
                    ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <!-- voor het symbol-->
                        <svg class="bi flex-shrink-0 me-2 " role="img" aria-label="Success: <symbol id=" check-circle-fill"
                            viewBox="0 0 16 16" width="50" height="35">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <div>
                            <p>U heeft een blog aangemaakt</p>
                        </div>
                    </div>
                <?php }
                //einde checks
                
                //de link naar het maken van een thema maar het moet nog mooigemaakt worden
                ?>
                <a class="nav-link active" href="themeInsert.php?id=<?= $session->userId ?>">
                    <h5>nieuw thema toevoegen</h5>
                </a>
                <a class="nav-link active" href="setInsert.php?id=<?= $session->userId ?>">
                    <h5>nieuw them toevoegen</h5>
                </a>
                <?php

                //checkt of er wel blogs zijn
                if ($themes) {
                    foreach ($themes as $theme) { ?>
                        <div class="col-3 mt-3">
                            <!--maakt een card voor elke blog-->
                            <div class="card mx-auto" style="width: 18rem;">
                                <!-- voor de blog informatie-->
                                <div class="card-body">
                                    <h5 class="card-title"><?= $theme->name ?></h5>
                                    <!-- de button in de kaart voor de editpagina-->
                                    <a href="themeEdit.php?id=<?= $theme->id ?>" class="btn btn-primary">Edit</a>
                                    <!-- de button in de kaart voor de deletepagina-->
                                    <a href="themeDelete.php?id=<?= $theme->id ?>" class="btn btn-primary">Delete</a>
                                </div>
                            </div>
                        </div>
                        <br>
                    <?php }
                } ?>
            </div>
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
            background: #0d1820;
            background-image: radial-gradient(circle at 21% 34%, rgba(151, 168, 66, 0.4), transparent 30%);
        }
    </style>
</div>

</body>

</html>