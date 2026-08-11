<?php
 header("Access-Control-Allow-Origin: https://mindease-smoky.vercel.app");
 header("Access-Control-Allow-Headers: Content-Type");
 header("Access-Control-Allow-Methods: POST, OPTIONS");
 header("Content-Type: application/json");

 if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
     http_response_code(200); 
      exit(); 
} 
 error_reporting(E_ALL);
 ini_set("display_errors", 0);

 include __DIR__ . "/../db.php";

  $data = json_decode(file_get_contents("php://input"), true); 

 if (!$data) { 
 echo json_encode([
 "status" => "no_data_received"
 ]); 
 exit(); 
} 
 $name = trim($data["name"] ?? "");
 $email = strtolower(trim($data["email"] ?? ""));
 $rawPassword = $data["password"] ?? ""; 

 if (!$name || !$email || !$rawPassword) { 
 echo json_encode([
 "status" => "missing_fields"
 ]);
 exit(); 
}

 $password = password_hash($rawPassword, PASSWORD_DEFAULT);

  $check = $conn->query(
   "SELECT * FROM users WHERE email='$email'" 
); 

 if ($check->num_rows > 0) { 
 echo json_encode([ 
 "status" => "exist"
 ]);
 exit(); 
}
 $sql = "INSERT INTO users
 (name, email, password) 
 VALUES
 ('$name', '$email', '$password')"; 
 if ($conn->query($sql) === TRUE) {
 $user_id = $conn->insert_id;
 echo json_encode([ 
 "status" => "success",
 "user_id" => $user_id,
 "name" => $name
 ]);
 } else { 
 echo json_encode([ 
 "status" => "error" 
 ]); 
}
 $conn->close(); 
 ?>