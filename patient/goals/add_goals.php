<?php
session_start();
include_once __DIR__."/../../conf.php";

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    exit("Unauthorized access");
}

$user_id = $_SESSION['id'];
$goal_text = isset($_POST['title']) ? trim($_POST['title']) : '';

if ($goal_text === '') {
    http_response_code(400);
    exit("Goal text cannot be empty");
}

$sql = "INSERT INTO Goals (user_id, goal_text) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $goal_text);

if ($stmt->execute()) {
    echo "Goal added successfully!";
} else {
    http_response_code(500);
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
