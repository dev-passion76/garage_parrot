<?php
//https://phpdelusions.net/pdo_examples/connect_to_mysql
session_start();

$host = '127.0.0.1';
$db   = 'garage';

/**
 * Données à modificer pour initialiser le dialogue avec la base de donnée MYSQL
 */

 // user 
$user = 'sandrine';
// mot de passe
$pass = 'Sandrine73&sql';
// port de communication avec la BDD
$port = "3306";




$charset = 'utf8mb4';
//Pour se connecter à une base de donnée MySql
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
/**
 * Init database connection
 */
$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
/*$dsn = "mysql:host=$db;host=localhost";*/
$pdo = new PDO($dsn, $user, $pass, $options);

// test
require_once '../lib/bib_general.php';
?>