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
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <!--vulling-->
                </div>

                <!-- begin van de navbar-->
                <nav class="navbar navbar-expand-lg bg-body-tertiary border border-black mb-1">
                    <div class="container-fluid">
                        <!--een foto aan het begin in de navbar om het mooi te maken-->
                        <a class="navbar-brand" href="../user/overview.php">
                            <img src="../images/image.png" alt="huis" width="50" height="35">
                        </a>
                        <!-- de foto een button maken-->
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
                        <!-- welkom tekst dat de gebruiker welkomt hangt af of het een admin of gebruiker is-->
                        <div class="container text-end">
                            <h4> Welkom tot de website gebruiker</h4>
                        </div>
                        <div class="col-1">
                            <!-- dit is opvulling voor de tekst zodat het in het midden is en niet schuin-->
                        </div>
                    </div>
                </nav>

                <!--einde navbar-->
                <!--begin van de php code-->

                <?
                //kijkt op je op de gebruiker knop drukt en stuurt je dan naar de gebruikers overview voor de blogs
                if (isset($_POST["userBtn"])) {
                    header("location: ../user/overview.php");
                }

                //check of er wat is ingevuld
                if (isset($_POST['username']) && ($_POST['password'])) {
                    //include alle classes
                    include "../classes/session.php";
                    include "../classes/user.php";
                    include "../classes/connection.php";

                    // post de username en password
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    // gebruikt de metode om de gebruik te vinden uit de database met de gegeven naam en wachtwoord
                    //
                    $user = User::findUser($username, $password);
                    // kijkt of er wel een gebruiker is met de juiste gebruikers gegevens die geven zijn
                    if ($user) {

                        //random key
                        $key = md5(uniqid(rand(), true));

                        //maakt nieuwe sessie aan en voegt toe aan de database
                        //
                        $session = new Session();
                        $session->userId = $user->id;
                        $session->key = $key;
                        $session->start = date("Y-m-d H:i:s");
                        $session->end = date("Y-m-d H:i:s", strtotime("+1 week"));
                        $session->insert();

                        //nieuw cookie
                        setcookie("speelhuys-project-cookie", $key, strtotime("+1 week"), "/");

                        //stuurt de admin naar de admin pagina met zijn userid
                        header("location: admin.php");
                    } else {
                        //voor als er geen gebruiker is gevonden wordt komt deze error bar
                
                        ?>
                        <!-- de errorbar-->
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <!--de error pictogram-->
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                                aria-label="Warning:" width="50" height="35">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>
                            <div>
                                <p>Incorecte inloggegevens probeer het opnieuw</p>
                            </div>
                        </div>
                        <?
                    }
                } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // error voor als er niks wordt ingevuld
                    ?><!-- de errorbar-->
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <!--de error pictogram-->
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                            aria-label="Warning:" width="50" height="35">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                        <div>
                            <p>Vul uw inloggegevens allemaal in AUB</p>
                        </div>
                    </div>
                    <?
                }
                ?>
                <!--eind fout code bar -->
                <!-- begin form-->
                <div class="col-3">
                    <!-- dit is voor opmaak van de form -->
                </div>
                <!-- de collum met de form als kaart-->
                <div class="col-6 mt-3">
                    <!-- mooi gemaakt met een card -->
                    <div class="card border-dark mb-3">
                        <div class="card-header">Uw inlog A.U.B.</div>
                        <div class="card-body">
                            <!-- de form waar de Admin zijn inlog invult-->
                            <form method="POST">
                                <h5 class="card-title">Gebruiker</h5>
                                <input type="text" name="username">

                                <h5 class="card-title">Wachtwoord</h5>
                                <input type="text" name="password"><br><br>

                                <button type="submit" name="adminBtn">
                                    <p>log in als admin</p>
                                </button>
                            </form><br>
                            <!-- een nieuw form voor de andere knop waar je op klikt als je geen admin bent -->
                            <form method="POST">
                                <button type="submit" name="userBtn">
                                    <p>Ik ben geen admin</p>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <!--vulling voor de form om het goed in het midden te behouden-->
                </div>
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