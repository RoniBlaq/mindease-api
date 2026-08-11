<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *"); 
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
  
  $sql = " SELECT community_posts.id, 
  community_posts.content, 
  community_posts.user_id,
  community_posts.created_at, 
  users.name,
   ( 
   SELECT COUNT(*) 
   FROM post_likes 
  WHERE post_likes.post_id =
   community_posts.id )
    AS like_count FROM community_posts
     LEFT JOIN users 
     ON community_posts.user_id = users.id
      ORDER BY community_posts.id DESC ";
  
  $result = $conn->query($sql); 

  if (!$result) {

    echo json_encode([

        "status" => "sql_error",

        "message" => $conn->error

    ]);

    exit;
}

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode($posts);

$conn->close();
       ?>