<?php
// include alle classes
include "../classes/session.php";
include "../classes/user.php";
include "../classes/connection.php";
include "../classes/set.php";

// check voor cookie
if (!isset($_COOKIE["speelhuys-project-cookie"])) {
    header("location: index.php?message=Geen cookie");
}
// alle gegevens ophalen uit de database
$conn = Database::start();
$session = Session::findSession();
$userId = $session->userId;
$user = User::findAdmin($userId);
$sets = Set::findAllsets();
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
                //checkt of er wel sets zijn
                ?>
                <!-- Knop om nieuwe set toe te voegen -->
                <div class="mb-3">
                <a class="btn btn-primary" href="setInsert.php?id=<?= $session->userId ?>">
                              + Nieuw set toevoegen
                </a>
               
                <div class="row justify-content-center g-4 mt-1">
                    <?php
                    if ($sets) {
                        foreach ($sets as $set) { ?>
                            <div class="col-11 col-sm-6 col-md-4 col-lg-3">
                                <!-- maakt een card voor elke set -->
                                <div class="card h-100 set-card">
                                    <!-- voor de foto van de set -->
                                    <div class="set-card-img-wrap">
                                        <img src="../upload/<?= $set->image ?>" class="set-card-img" alt="<?= $set->name ?>">
                                    </div>
                                    <!-- voor de blog informatie -->
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?= $set->name ?></h5>
                                        <div class="mt-auto d-flex gap-2">
                                            <a href="setEdit.php?id=<?= $set->id ?>" class="btn btn-primary flex-fill">Edit</a>
                                            <a href="setDelete.php?id=<?= $set->id ?>" class="btn btn-outline-danger flex-fill">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>

    </body>

</html>