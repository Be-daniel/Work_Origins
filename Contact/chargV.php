<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Vérification de l'existence du fichier .env
// if (file_exists(__DIR__ . '/Contact/.env')) {
//     echo ".env file found.";
// } else {
//     echo ".env file not found.";
//     exit;
// }

$dotenv = Dotenv::createImmutable('C:/wamp64/www/Work_Origins/Contact');
$dotenv->load();

// Test pour vérifier que les variables sont bien chargées
if (isset($_ENV['SMTP_USERNAME']) && isset($_ENV['SMTP_PASSWORD'])) {
    echo "SMTP_USERNAME: " . $_ENV['SMTP_USERNAME'] . "<br>";
    echo "SMTP_PASSWORD: " . $_ENV['SMTP_PASSWORD'] . "<br>";
} else {
    echo "Les variables d'environnement n'ont pas été chargées correctement.";
}
