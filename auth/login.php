<?php

require "../vendor/autoload.php";
require "../dbconnection.php";
require "./auth_module.php";

use Ramsey\Uuid\Uuid;

/**
 * POSt
 * /auth/login.php
 * route dédiée à l'obtention d'un token
 * corps de la requête attendu (JSON) :
 * {
 *      "username" : "exampleusername",
 *      "password" : "examplepassword"
 * }
 */

// les données raw de POST (donc une string JSON)

$post_body = file_get_contents('php://input');
$post_body_array = json_decode($post_body, true);

// verification que le corps de la requête est entier

if ($post_body == null) {
    echo json_encode(["error" => "vous n'avez passé aucune donnée dans la requête POST"]);
    exit();
} else if (array_key_exists("username", $post_body_array) == false) {
    echo json_encode(["error" => "vous devez fournir un nom d'utilisateur"]);
    exit();
} else if (array_key_exists("password", $post_body_array) == false) {
    echo json_encode(["error" => "vous devez fournir un mot de passe"]);
    exit();
}

// vérifications de l'existane de l'utiliseur et de la correspondance du mot de passe

$userData = $conn->query("SELECT * FROM `users` WHERE username = '"
    . $post_body_array["username"] . "' AND password = '"
    . $post_body_array["password"] . "'")->fetch();

if ($userData == false) {
    echo (json_encode(["error" => "l'utilisateur n'existe pas ou le mot de passe est incorrect"]));
    exit();
}

// TODO retourner un token

// $currentYear = date("Y");
// $currentMonth = date("m");
// $currentDay = date("d");

$token = Uuid::uuid4();

// $d = mktime(0, 0, 0, 4, 1, 2020);

// demain > maintenant

// echo new DateTime("yesterday") < new DateTime("now");

$datenow = new DateTime("now");
$limitDateToTken = date_add($datenow, date_interval_create_from_date_string('10 days'));

$tokenToReturn = $token . "/" . $limitDateToTken->format("d-m-Y");

// on met le token dans la db

try {
    $sql = "UPDATE `users` SET `current_token` = '" . $tokenToReturn .  "' WHERE `users`.`id` = " . $userData["id"];
    $conn->exec($sql);
    // renvoyer le token en cas de succès
    echo json_encode(["token" => $tokenToReturn]);
    exit();
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit();
}
