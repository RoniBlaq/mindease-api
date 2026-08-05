<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$dbHost = $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST');
$dbUser = $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER');
$dbPass = $_ENV['MYSQLPASSWORD']?? getenv('MYSQLPASSWORD');
$dbName = $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE');
$dbPort = $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT');

$conn = new mysqli( 
    $dbHost,
    $dbUser,
    $dbPass,
    $dbName,
    (int)$dbPort
    );
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");

// $host ="";
// $user = "";
// $password = "";
// $database = "";

// $conn = new mysqli($host, $user, $password, $database);

// if ($conn->connect_error) {
//     die("connection failed: " . $conn->connect_error);
// }


?>
?>/