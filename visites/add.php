<?php

require "../vendor/autoload.php";
require "../dbconnection.php";
require "../auth/auth_module.php";

// use Ramsey\Uuid\Uuid;

/**
 * POST
 * /visites/add.php
 * route dédiée l'ajout d'une visite dans la bd pour un visiteur
 * corps de la requête attendu (JSON) :
 * {
 *      "token_visiteur" : "0aba80e2-3c10-4e6a-86cb-30e873e5ce17/18-04-2021",
 *      "id_cabinet" : "2",
 *      "id_medecin" : "2",
 *      "date_visite": "2021-12-01",
 *      "sur_rdv" : 0, (ou quoi que ce soit d'autre pour true)
 *      "heure_arrivee": 12,
 *      "heure_debut": 13,
 *      "heure_depart": 14"
 * }
 */

// les données raw de POST (donc une string JSON)

$post_body = file_get_contents('php://input');
$post_body_array = json_decode($post_body, true);

// checker le token envoyé

$user = checkTokenValid($post_body_array["token_visiteur"]);

if ($user == null) {
    exit();
}

// si le token est valide, ajouter la visite

try {
    $sql = "INSERT INTO `visite` (`id`, `id_visiteur`, `id_cabinet`, `id_medecin`, `date_visite`, `sur_rdv`, `heure_arrivee`, `heure_debut`, `heure_depart`) 
    VALUES (NULL, '" . $user["id"] . "', '" . $post_body_array["id_cabinet"] . "', '" . $post_body_array["id_medecin"] . "', ' " . $post_body_array["date_visite"] . "', '" . $post_body_array["sur_rdv"] . "', '" . $post_body_array["heure_arrivee"] . "', '" . $post_body_array["heure_debut"] . "', '" . $post_body_array["heure_depart"] . "')";
    $conn->exec($sql);
    echo json_encode(["success" => "la visite a été ajoutée avec succès"]);
    exit();
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit();
}
