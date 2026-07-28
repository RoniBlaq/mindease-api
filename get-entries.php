<?php 
 header("Access-Control-Allow-Origin: https://mindease-smoky.vercel.app");
header("Access-Control-Allow-Headers: Content-Type");
 header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exist();
}
  error_reporting(E_ALL);
 ini_set('display_errors', 0);

include "db.php"; 

 $sql = "SELECT * FROM journal_entries ORDER BY created_at DESC";

 $result = $conn->query($sql);

 $entries = [];

 while ($row = $result->fetch_assoc()) {
    $entries[] = $row;
 }

 echo json_encode($entries);

 $conn->close();

?>