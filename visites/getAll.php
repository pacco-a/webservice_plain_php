<?php

require("../auth/auth_module.php");
require("../dbconnection.php");

/**
 * GET
 * /visites/getAll.php
 * route dédiée la récupération
 * paramètres GET attendus :
 *  visiteur_token (token du visiteur dont on veut récupérer les visites)
 */

if (array_key_exists('visiteur_token', $_GET) == false) {
    echo json_encode(["error" => "vous n'avez pas passer de visiteur_token dans la requête GET"]);
    exit();
}

$user = checkTokenValid($_GET["visiteur_token"]);

if ($user == null) {
    exit();
}

$visites = $conn->query("SELECT * FROM `visite` WHERE visite.id_visiteur = " . $user["id"])->fetchAll(PDO::FETCH_UNIQUE);

echo json_encode($visites);
