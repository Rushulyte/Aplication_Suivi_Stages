<?php
    require_once("../plugins/connexion.php");

    if (isset($_POST['login']) and isset($_POST['mdp'])) {

        $login = $_POST['login'];
        $password = $_POST['mdp'];
        $hashed = hash("sha512", $password);

        $q_select = "SELECT users.authentication_string AS 'MDP', users.id_account_type AS 'TYPE' 
                     FROM USERS 
                     WHERE users.login = ?";

        $cursor = $connexion -> prepare($q_select);
        $cursor -> execute([$login]);

        $found = False;
        foreach ($cursor -> fetchAll() as $row) {

            if ($hashed == $row["MDP"]){
                $found = True;

                if ($row["TYPE"] == 1) {
                    header("Location: accounts_manager.php");
                    die();

                } else if ($row["TYPE"] == 2){
                    header("Location: dashboard.php");
                    die();
                } else if ($row["TYPE"] == 3){
                    header("Location: dashboard.php");
                    die();
                } else {
                    header("Location: login.php?login=False");
                    die();

                }
            }
        }

        if (!$found) {
            header("Location: login.php?login=invalid");
            die();
        }
    }
    else {
        header("Location: login.php?login=false");
        die();

    }
