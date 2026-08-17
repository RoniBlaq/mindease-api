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
 
  include __DIR__ . "/../db.php"; 
  
  $data = json_decode(file_get_contents("php://input"), true); $post_id = $data["post_id"] ?? 0;
   $user_id = $data["user_id"] ?? 0;
   if (!$post_id || !$user_id) { 
    echo json_encode([
         "status" => "missing_fields" 
         ]); 
         exit;
          }
   // Check if already liked 
   $check = $conn->prepare(
     "SELECT id FROM post_likes WHERE 
     post_id = ? AND user_id = ?" 
     );
      $check->bind_param("ii", $post_id, $user_id);
       $check->execute(); 
       $result = $check->get_result();
        if ($result->num_rows > 0) { 
    // Unlike
     $delete = $conn->prepare(
         "DELETE FROM post_likes
          WHERE post_id = ? AND user_id = ?"
           );
            $delete->bind_param("ii", $post_id, $user_id);
             $delete->execute();
              echo json_encode([ 
                "status" => "unliked" 
                ]);
                 } else {
                     // Like 
                     $insert = $conn->prepare( 
                        "INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)"
                         );
                      $insert->bind_param("ii", $post_id, $user_id);
                       $insert->execute();
                        echo json_encode([ 
                            "status" => "liked" 
                            ]); 
                            } 
                            $conn->close();
                             ?>