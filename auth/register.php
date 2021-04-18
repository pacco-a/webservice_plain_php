<?php

require "../vendor/autoload.php";
require "../dbconnection.php";

/**
 * /auth/register.php
 * route dédiée à l'inscription d'un nouvel utilisateur
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

// vérifications de doublons dans db avant inscription

$data = $conn->query("SELECT * FROM `users` WHERE username = '" . $post_body_array["username"] . "'")->fetch();

if ($data != false) {
    echo json_encode(["error" => "l'utilisateur existe déjà dans la base de donnée"]);
    exit();
}

// inscription dans la db

try {
    $sql = "INSERT INTO `users` (`id`, `username`, `password`, `current_token`) 
    VALUES (NULL, '" . $post_body_array["username"] . "', '" . $post_body_array["password"] . "', NULL)";
    $conn->exec($sql);
    echo json_encode(["success" => "l'utilisateur a été ajouté avec succès"]);
    exit();
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit();
}
