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

    include '../plugins/connexion.php';

    $get_users = '
                    SELECT
                        U.identifiant as id, 
                        U.last_name as last,
                        U.first_name as first,
                        A.name as type 
                    FROM users U
                        INNER JOIN account_types A on U.id_account_type = A.id;
                '; ?>

    <form action="#">
        <input type="submit" name="update" value="Ajouter" onclick="update()">
        <input type="submit" name="delete_" value="Modifier" onclick="delete_()">
    </form>

    <?php
    function update(){
        echo "foo";
    }
    function delete_(){
        print_r("foo");
    } ?>

    <table>
        <thead>
        <tr>
            <th>login</th>
            <th>nom</th>
            <th>prénom</th>
            <th>type</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $cursor = $connexion->prepare($get_users);
        $cursor->execute();

        foreach ($cursor->fetchAll(PDO::FETCH_ASSOC) as $table_row) {
            echo '<tr>';
            foreach ($table_row as $value) {
                echo "<td>$value</td>";
            }
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</main>
</body>
</html>