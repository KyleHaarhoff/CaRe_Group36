<?php
session_start(); // Start session to get patient ID

include "../../common/db/db-conn.php"; // Include your database connection

// Check if patient_id is set in the session
if (isset($_SESSION['patient_id'])) {
    $patient_id = $_SESSION['patient_id'];

    $sql = "SELECT * FROM journal_entries WHERE patient_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='journal-entries'>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='journal-entry'>";
                echo "<p>Date: " . htmlspecialchars($row['journal_date']) . "</p>";
                echo "<p>Hours Slept: " . htmlspecialchars($row['hours_slept']) . "</p>";
                echo "<p>Mood: " . htmlspecialchars($row['mood']) . "</p>";
                echo "<p>Meals Eaten: " . htmlspecialchars($row['meals_eaten']) . "</p>";
                echo "<p>Exercise: " . ($row['exercise'] ? 'Yes' : 'No') . "</p>";
                echo "<p>Journal: " . htmlspecialchars($row['journal_entry']) . "</p>";
                if (!empty($row['file_path'])) {
                    echo "<p><a href='" . htmlspecialchars($row['file_path']) . "'>Download Attached File</a></p>";
                }
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No journal entries found.</p>";
        }

        $stmt->close(); // Close the statement
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
    }
} else {
    echo "Patient not logged in.";
}

$conn->close(); // Close the database connection
?>
