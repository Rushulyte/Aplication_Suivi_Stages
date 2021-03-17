<?php define('__TEMPLATES__', dirname(__FILE__) . '/templates') ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Connexion</title>
        <?php require_once(__TEMPLATES__.'/meta.html'); ?>
        <link rel="stylesheet" href="css/main.css">
        <link rel="icon" href="svg/favicon.svg">
    </head>
    <body>
        <header>
            <?php require_once(__TEMPLATES__.'/navbar.html'); ?>
        </header>

        <main>
            <h1>Authentification</h1>

            <p><?php
                if (isset($_GET["login"]))
                {
                    $issue = $_GET["login"];

                    if ($issue == "false")
                    {
                        echo "Veuillez entrer un nom et un mot de passe pour vous connecter";

                    } elseif ($issue == "invalid") {
                        echo "Le nom ou le mot de passe est incorrect !";

                    } else {
                        echo "Une erreur inconnue s'est produite durant la validation";

                    }
                } else {
                    echo "Authentifiez vous avec vos identifiants du domaine SIO.Fulbert (Active Directory)";

                }
            ?></p>

            <form action="redirection.php" method="POST">
                <div class="equalizer">
                    <label for="id">Identifiant<input type="text" name="login" required></label>
                    <label for="mdp">Mot de Passe<input type="password" name="mdp"  minlength="8" required></label>
                </div>
                <div class="container">
                    <input type="submit" value="Valider">
                    <input type="reset" value="Annuler" accesskey="r">
                </div>
            </form>
        </main>
    </body>
</html>