<?php
session_start(); // Start session to get patient ID

include "../../common/db/db-conn.php";

// Use session-based patient ID
$patient_id = $_SESSION['patient_id'];

$sql = "SELECT * FROM journal_entries WHERE patient_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<div class='journal-entries'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='journal-entry'>";
        echo "<p>Date: " . $row['journal_date'] . "</p>";
        echo "<p>Hours Slept: " . $row['hours_slept'] . "</p>";
        echo "<p>Mood: " . $row['mood'] . "</p>";
        echo "<p>Meals Eaten: " . $row['meals_eaten'] . "</p>";
        echo "<p>Exercise: " . ($row['exercise'] ? 'Yes' : 'No') . "</p>";
        echo "<p>Journal: " . $row['journal_entry'] . "</p>";
        if (!empty($row['file_path'])) {
            echo "<p><a href='" . $row['file_path'] . "'>Download Attached File</a></p>";
        }
        echo "</div>";
    }
    echo "</div>";
}
?>
