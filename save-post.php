<!-- <?php

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

// include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$content = $data["content"];

$sql ="INSERT INTO community_posts (contents)
             VALUES ('$content')";

  if ($conn->query($sql) === TRUE) {
    echo json_encode([
        "status" => "success"
    ]);
  } else {
    echo json_encode([
        "status" => "error"
    ]);
  }
  $conn->close();
?> -->