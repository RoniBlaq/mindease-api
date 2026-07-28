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

$user_id = $_GET["user_id"] ?? 0;

// Journal Entries

$j_sql = "
SELECT COUNT(*) as total
FROM journal_entries
WHERE user_id = '$user_id'
";

$j_result = $conn->query($j_sql);

$j_count = $j_result->fetch_assoc()["total"];

// Mood Entries

$m_sql = "
SELECT COUNT(*) as total
FROM moods
WHERE user_id = '$user_id'
";

$m_result = $conn->query($m_sql);

$m_count = $m_result->fetch_assoc()["total"];

// Focus Sessions

$f_sql = "
SELECT COUNT(*) as total
FROM focus_sessions
WHERE user_id = '$user_id'
";

$f_result = $conn->query($f_sql);

$f_count = $f_result->fetch_assoc()["total"];

// Community Posts

$c_sql = "
SELECT COUNT(*) as total
FROM community_posts
WHERE user_id = '$user_id'
";

$c_result = $conn->query($c_sql);

$c_count = $c_result->fetch_assoc()["total"];

// Response

echo json_encode([

    "journal" => $j_count,
    "mood" => $m_count,
    "focus" => $f_count,
    "community" => $c_count

]);

$conn->close();

?>