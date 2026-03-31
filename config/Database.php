<?php
    //====== https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/connexion-base-donnee-mysqli-pdo/====== 
    //PHP
    // ↓
    //PDO
    // ↓
    //MySQL
    
declare(strict_types=1);

//Fonction pour obtenir la connexion à la BDD
function getDatabaseConnection(): PDO
{
    static $pdo = null;


    //Si la connexion existe déjà on la retourne
    //Ca ne va jamais etre le cas, voir ligne 14
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = '127.0.0.1'; //Adresse serveur MySQL
    $port = '3306'; //Port MySQL
    $dbname = 'helpdesk'; //Nom BDD
    $username = getenv('DB_USER') ?: ''; //Nom utilisateur MySQL
    $password = getenv('DB_PASS') ?: '';

    //Création DSN
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $dbname);

    //Création de la connexion PDDO
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}
