<?php

include_once "../../conf.php";
session_start();
#Access control
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
}

$image_id = htmlspecialchars($_GET['id']); 

$sql= "SELECT journal_images.image_data as image_data FROM `journal_images` LEFT JOIN journal_entries on journal_id = journal_entries.id WHERE journal_images.id = ? and patient_id=?;";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, 'ii',$image_id, $_SESSION['id']);

    mysqli_stmt_execute($stmt);

    if($result = mysqli_stmt_get_result($stmt)) {
        $image=mysqli_fetch_assoc($result);
    }
}
// If an image is found
if ($image['image_data']) {
    // Output the image data
    echo $image['image_data'];
} else {
    echo "Image not found.";
}

// Close connections
$stmt->close();
$conn->close();

?>