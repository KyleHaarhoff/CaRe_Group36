<?php

include_once __DIR__ . "/../conf.php";
session_start();
#Access control
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
}
$sql= "SELECT * FROM Users where id = ?;";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);

    mysqli_stmt_execute($stmt);
    if($result = mysqli_stmt_get_result($stmt)) {
        $user=mysqli_fetch_assoc($result);
    }
}


#Access control


$sql= "SELECT * FROM Users where id = ?;";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);

    mysqli_stmt_execute($stmt);
    if($result = mysqli_stmt_get_result($stmt)) {
        $user=mysqli_fetch_assoc($result);
    }
}
// If an image is found
if ($user['profile_image']) {
    // Output the image data
    echo $user['profile_image'];
} else {
    echo "Image not found.";
}

// Close connections
$stmt->close();
$conn->close();

?>