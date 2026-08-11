<?php 

header("Access-Control-Allow-Origin: https://mindease-smoky.vercel.app");
header("Access-Control-Allow-Headers: Content-Type");
 header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
  error_reporting(E_ALL);
 ini_set('display_errors', 0);
  
 include "db.php";
  
  $data = json_decode(file_get_contents("php://input"), true); 
  
  if (!$data) {
    echo json_encode([
        "status" => "no_data"
    ]);
    exit();
  }

   $user_id = $data["user_id"] ?? 0; 
  $mood =trim($data["mood"] ?? "");
  
   if (!$user_id || !$mood) { 
    echo json_encode([ 
        "status" => "missing_fields" 
        ]);
         exit();
          } 

          $stmt = $conn->prepare(" INSERT INTO moods (user_id, mood) VALUES (?, ?) ");

           $stmt->bind_param("is", $user_id, $mood);
           
           if ($stmt->execute()) {
           echo json_encode([ 
           "status" => "success" 
             ]);
              } else { echo json_encode([ 
               "status" => "error","message" => $stmt->error
                    ]);
                     } 
              $stmt->close();       
              $conn->close();
                      ?>