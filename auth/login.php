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

$rawData = file_get_contents("php://input");

$data = json_decode($rawData, true);

if (!$data) {
    echo json_encode([
        "status" => "no_data_received",
        "raw" => $rawData
    ]);
    exit();
}

$email = strtolower(trim($data["email"] ?? ""));
$password = $data["password"] ?? "";

if (!$email || !$password) {
    echo json_encode([
        "status" => "missing_fields"
    ]);
    exit();
}

$stmt = $conn->prepare(
    "SELECT id, name, password
     FROM users
     WHERE LOWER(TRIM(email)) = LOWER(TRIM(?))"
);

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user["password"])) {

        echo json_encode([
            "status" => "success",
            "user_id" => $user["id"],
            "name" => $user["name"]
        ]);

    } else {

        echo json_encode([
            "status" => "wrong_password"
        ]);
    }

} else {

    echo json_encode([
        "status" => "not_found"
    ]);
}

$stmt->close();
$conn->close();

?>