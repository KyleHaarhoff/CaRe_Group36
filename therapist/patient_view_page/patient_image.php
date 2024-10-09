<?php
#Access control
include_once "../../conf.php";
session_start();
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}
//check if the user is allowed to view this page
if ($_SESSION['user_type'] != 2) {
    http_response_code(403);
    echo "<h1>403 Forbidden</h1>";
    echo "<p>You are not authorized to access this page.</p>";

    exit();
} 


$sql= "SELECT * FROM `patient_therapist` LEFT JOIN users on patient_therapist.patient_id = users.id 
where patient_therapist.therapist_id = ? and patient_therapist.patient_id = ?;";
$patient_id = htmlspecialchars($_GET['patient_id']);
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['id'],$patient_id);

    mysqli_stmt_execute($stmt);
    if($result = mysqli_stmt_get_result($stmt)) {
        $patient=mysqli_fetch_assoc($result);
}
}
// If an image is found
if ($patient['profile_image']) {
    // Output the image data
    echo $patient['profile_image'];
} else {
    echo "Image not found.";
}

// Close connections
$stmt->close();
$conn->close();

?>