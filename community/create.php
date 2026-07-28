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

include __DIR__ . "/../db.php";

$data = json_decode(file_get_contents("php://input"), true); 

if (!$data) {

echo json_encode([
    "status" => "no_data"
]);
    exit();
}

$user_id = $data["user_id"] ?? 0;
 $content = trim($data["content"] ?? "");
 
 if (!$user_id || !$content) {
     echo json_encode([
        "status" => "missing_fields"
        ]); 
     exit();
      }
      
      $stmt = $conn->prepare(
         "INSERT INTO community_posts (user_id, content)
          VALUES (?, ?)"
           );

            $stmt->bind_param("is", $user_id, $content); 
            
            if ($stmt->execute()) { 
                echo json_encode(["status" => "success"
                ]);
                 } else {
         echo json_encode([
              "status" => "error",
              "message" => $stmt->error
               ]);
                  }
         $stmt->close();
             $conn->close();

                        ?>