<?php
session_start(); // Start the session to access session variables
$_SESSION['patient_id'] = 2;

include '../../common/db/db-conn.php'; // Include your database connection

// Check if patient_id is stored in the session after login
if (isset($_SESSION['patient_id'])) {
    $patient_id = $_SESSION['patient_id'];
} else {
    // Redirect to login page or handle error
    echo "Patient not logged in.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $journal_date = $_POST['journal-date'];
    $hours_slept = $_POST['hours-slept'];
    $mood = $_POST['mood'];
    $meals_eaten = $_POST['meals-eaten'];
    $exercise = isset($_POST['exercise']) ? 1 : 0; // Convert checkbox to boolean
    $journal_entry = $_POST['journal-entry'];

    // Handle file upload
    $file_path = ''; // Initialize file path
    if (isset($_FILES['files']) && $_FILES['files']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Specify your upload directory
        $target_file = $target_dir . basename($_FILES["files"]["name"]);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["files"]["tmp_name"], $target_file)) {
            $file_path = $target_file; // Set file path if upload is successful
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit; // Exit if file upload fails
        }
    }

    // Prepare SQL INSERT statement
    $sql = "INSERT INTO journal_entries (patient_id, journal_date, hours_slept, mood, meals_eaten, exercise, journal_entry, file_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param('issiiiss', $patient_id, $journal_date, $hours_slept, $mood, $meals_eaten, $exercise, $journal_entry, $file_path);
        
        // Execute statement
        if ($stmt->execute()) {
            echo "Journal entry added successfully!";
        } else {
            echo "Error: " . $stmt->error; // Display error if execution fails
        }
        
        $stmt->close(); // Close statement
    } else {
        echo "Error preparing statement: " . $conn->error; // Display error if preparation fails
    }

    $conn->close(); // Close database connection
} else {
    echo "Invalid request method."; // Handle invalid request method
}
?>
