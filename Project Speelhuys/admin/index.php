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

<body>
    <div class="page-shell">
        <div class="container-fluid">
            <!-- begin van de navbar-->
            <nav class="navbar navbar-expand-lg mb-1">
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
                    <div class="container text-end">
                        <h4>Welkom bij Speelhuys</h4>
                    </div>
                </div>
            </nav>
            <!--einde navbar-->

            <div class="content-area">
                <?php
                if (isset($_POST["userBtn"])) {
                    header("location: ../user/overview.php");
                }

                if (isset($_POST['username']) && ($_POST['password'])) {
                    include "../classes/session.php";
                    include "../classes/user.php";
                    include "../classes/connection.php";

                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    $user = User::findUser($username, $password);
                    if ($user) {
                        $key = md5(uniqid(rand(), true));

                        $session = new Session();
                        $session->userId = $user->id;
                        $session->key = $key;
                        $session->start = date("Y-m-d H:i:s");
                        $session->end = date("Y-m-d H:i:s", strtotime("+1 week"));
                        $session->insert();

                        setcookie("speelhuys-project-cookie", $key, strtotime("+1 week"), "/");
                        header("location: brandPage.php");
                    } else {
                        ?>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                                        aria-label="Warning:" width="30" height="25">
                                        <path
                                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </svg>
                                    <div>
                                        <p class="mb-0">Incorrecte inloggegevens, probeer het opnieuw</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                                    aria-label="Warning:" width="30" height="25">
                                    <path
                                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </svg>
                                <div>
                                    <p class="mb-0">Vul uw inloggegevens allemaal in AUB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <!-- begin form-->
                <div class="row justify-content-center mt-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card mb-3">
                            <div class="card-header">Uw inlog A.U.B.</div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3 text-start">
                                        <label for="username" class="form-label">Gebruiker</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Gebruikersnaam">
                                    </div>

                                    <div class="mb-3 text-start">
                                        <label for="password" class="form-label">Wachtwoord</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Wachtwoord">
                                    </div>

                                    <button type="submit" name="adminBtn" class="btn btn-primary w-100 mb-2">
                                        log in als admin
                                    </button>
                                </form>

                                <form method="POST">
                                    <button type="submit" name="userBtn" class="btn btn-outline-light w-100">
                                        Ik ben geen admin
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- eind form -->
            </div>
        </div>
    </div>
</body>

</html>