<?php
session_start();

if (empty($_SESSION)) {
    header('Location: login.php?error=unset');
    die();
}

if (!isset($_SESSION['type'])) {
    header('Location: login.php?error=unset');
    die();
}

if ($_SESSION['type'] !== 'admin') {
    header('Location: dashboard.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestionnaire de sessions</title>
    <?php require_once('../templates/meta.html'); ?>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/table.css">
    <link rel="icon" href="../../svg/favicon.svg">
</head>
<body>
<header>
    <nav>
        <a class="clickable" id="nav" href="dashboard.php">
            <img src="../../svg/sio.svg" alt="236">
        </a>
    </nav>
</header>
<main>

    <?php

    if ($_SESSION['type'] === 'admin') {
        echo '<form action="#" method="GET">
               <input type="submit" name="action" value="Ajouter">
               <input type="submit" name="action" value="Modifier">
               <input type="submit" name="action" value="Supprimer">
              </form>';
    }

    include '../plugins/connexion.php';

    $get_users = '
    SELECT
        U.identifiant as id, 
        U.last_name as last,
        U.first_name as first,
        U.authentication_string as mdp,
        A.name as type 
    FROM users U
    INNER JOIN account_types A on U.id_account_type = A.id;
    ';

    $cursor = $connexion->prepare($get_users);
    $cursor->execute();

    echo '<table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Mot de passe hashé</th>
            <th>Type</th>
        </tr>
        <tbody>';

    foreach ($cursor->fetchAll(PDO::FETCH_ASSOC) as $table_row) {
        echo '<tr>';
        foreach ($table_row as $value) {
            echo "<td>$value</td>";
        }
        echo '</tr>';
    }

    echo '</tbody></table>';


    if ($_SESSION['type'] === 'admin') {

        if (empty($_GET)) {
            die();
        }

        if (!isset($_GET['action'])) {
            die();
        }

        echo '<form action="#" method="GET">
                <input type="submit" name="action" value="Annuler">
              </form>';

        if ($_GET['action'] == 'Annuler') {
            header('Location: account_manager.php');
            die();
        }

        switch ($_GET['action']) {
            case 'Ajouter' :
                echo '<form action="crud_users.php?action=Ajouter" method="POST">';
                break;
            case 'Modifier' :
                echo '<form action="crud_users.php?action=Modifier" method="POST">';
                break;
            case 'Supprimer' :
                echo '<form action="crud_users.php?action=Supprimer" method="POST">';
                break;
        }

        echo '<label><input type="text" name="ID" placeholder="ID" required></label>
              <label><input type="text" name="nom" placeholder="Nom" required></label>
              <label><input type="text" name="prenom" placeholder="Prénom" required></label>
              <label><input type="password" name="mdp" placeholder="Mot de passe"></label>
              <label><input type="text" name="type" placeholder="Type"></label>
              <input type="submit" name="validation" value="Valider">
              <input type="reset" name="validation" value="Annuler">
              </form>';

    } ?>

</main>
</body>
</html>