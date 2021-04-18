<?php
// HEADERS
//  header('Content-Type: application/json');

require "vendor/autoload.php";
require "dbconnection.php";

use Ramsey\Uuid\Uuid;

// calcul

echo "ah : " . isset($conn);
echo "<br/>";

$uuid = Uuid::uuid4();

$gets = [];

foreach (array_keys($_GET) as $key) {
    $gets[$key] = $_GET[$key];
}

// retourner du json

echo json_encode($gets);
