<?php

require "../vendor/autoload.php";
require "../dbconnection.php";

/**
 * module helper avec des fonctions
 * relatives a l'authentification et plus
 * spécifiquement aux tokens
 */

function checkTokenValid($token)
{
    // example de token : 0aba80e2-3c10-4e6a-86cb-30e873e5ce17/18-04-2021

    global $conn;

    // check date
    $tokenYear = substr($token, strlen($token) - 4, 4);
    $tokenMonth = substr($token, strlen($token) - 7, 2);
    $tokenDay = substr($token, strlen($token) - 10, 2);

    $tokenDate = new DateTime($tokenYear . "-" . $tokenMonth . "-" . $tokenDay);

    // check user

    $userData = $conn->query("SELECT * FROM `users` WHERE users.current_token = '" . $token . "'")->fetch();

    if ($userData == null) {
        echo json_encode(["error" => "aucun utilisateur associé à ce token n'a été trouvé"]);
        return null;
        exit();
    }

    // check if token not outdated

    if ($tokenDate < new DateTime("now")) {
        echo json_encode(["error" => "le token n'est plus à jour veuillez en obtenir un nouveau /auth/login.php"]);
        return null;
        exit();
    }

    // si on a trouvé un utilisateur et que le token n'est pas outdated on renvoi true

    return $userData;
}
