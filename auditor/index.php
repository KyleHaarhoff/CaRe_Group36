<?php

require_once "../common/db/db-conn.php"; 

// SQL query to get the auditor report
$sql = "
    SELECT 
        t.name AS therapist_name,
        COUNT(DISTINCT pt.patient_id) AS number_of_patients,
        GROUP_CONCAT(DISTINCT c.case_type) AS case_types,
        SUM(s.session_length) AS total_session_length
    FROM 
        therapists t
    LEFT JOIN 
        patient_therapist pt ON t.id = pt.therapist_id
    LEFT JOIN 
        Sessions s ON pt.patient_id = s.p_id
    LEFT JOIN 
        Cases c ON t.id = c.id
    GROUP BY 
        t.id;
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditor Report</title>
    <link rel="stylesheet" href="../auditor/auditor.css"> 
</head>
<body>
    <h1>Auditor Report</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Therapist Name</th>
                <th>Number of Patients</th>
                <th>Case Types</th>
                <th>Total Session Length (minutes)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['therapist_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['number_of_patients']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['case_types']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_session_length']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
