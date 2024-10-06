<?php
include '../../common/db/db-conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = 1; // Use session or dynamic patient ID in production
    $journal_date = $_POST['journal-date'];
    $hours_slept = $_POST['hours-slept'];
    $mood = $_POST['mood'];
    $meals_eaten = $_POST['meals-eaten'];
    $exercise = isset($_POST['exercise']) ? 1 : 0;
    $journal_entry = $_POST['journal-entry'];

    // File upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["files"]["name"]);
    move_uploaded_file($_FILES["files"]["tmp_name"], $target_file);

    // Insert into database
    $sql = "INSERT INTO journal_entries (patient_id, journal_date, hours_slept, mood, meals_eaten, exercise, journal_entry, file_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('isisiiss', $patient_id, $journal_date, $hours_slept, $mood, $meals_eaten, $exercise, $journal_entry, $target_file);
        $stmt->execute();
        echo "Journal entry added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
