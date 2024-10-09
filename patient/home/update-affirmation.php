<?php
session_start();
include_once __DIR__."/../../conf.php";

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    exit("Unauthorized access");
}
//check if the user is allowed to view this page
if ($_SESSION['user_type'] != 1) {
    http_response_code(403);
    exit("Unauthorized access");

}

$affirmation = isset($_POST['affirmation']) ? trim($_POST['affirmation']) : '';
$affirmation = htmlspecialchars($affirmation);

if ($affirmation === '') {
    http_response_code(400);
    exit("Goal text cannot be empty");
}



$sql = "UPDATE Affirmations SET affirmation = ? where patient_id = ?; ";
$stmt = $conn->prepare($sql);

$stmt->bind_param("si", $affirmation, $_SESSION['id']);


if ($stmt->execute()) {

    
    header("location: home.php?notification=true&success=true&message=Affirmation updated sucessfully");
} else {
    header("location: goals.php?notification=true&success=false&message=An error occurred");
}
                
?>