<?php

include "../common/db/db-conn.php"; 

// Query to fetch data for auditors
$sql = "
    SELECT 
        u.first_name AS therapist_name,
        COUNT(tp.patient_id) AS patient_count,
        GROUP_CONCAT(DISTINCT tp.case_type) AS case_types,
        SUM(tp.session_length) AS total_session_time
    FROM Users u
    JOIN UserType ut ON u.id
    JOIN Patient_Therapist tp ON t.therapist_id = tp.therapist_id
    WHERE ut.type='Therapist'
    GROUP BY u.first_name
";

$result = $conn->query($sql);

// Display data in a table format
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Therapist Name</th>
                <th>Number of Patients</th>
                <th>Case Types</th>
                <th>Total Session Time (minutes)</th>
            </tr>";
    
    // Fetch and display each row of data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['therapist_name'] . "</td>
                <td>" . $row['patient_count'] . "</td>
                <td>" . $row['case_types'] . "</td>
                <td>" . $row['total_session_time'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No data found.";
}

$conn->close();

