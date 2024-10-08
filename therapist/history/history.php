<?php
    #Access control
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History </title>
    <link rel="stylesheet" href="history.css">

</head>

<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?>
    </header>
    <main class="main">

        <table class="history_table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Entry</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Prepare the SQL statement with a placeholder
                $sql = "SELECT id,journal_date, journal_entry, mood FROM journal_entries WHERE patient_id = ? ORDER BY journal_date DESC";

                // Create a prepared statement
                $stmt = $conn->prepare($sql);

                // Bind the dynamic patient_id value (e.g., 1 for now, change it dynamically later)
                $patient_id = 1;
                $stmt->bind_param("i", $patient_id); // "i" stands for integer

                // Execute the statement
                $stmt->execute();

                // Fetch the result
                $result = $stmt->get_result();

                // Display fetched data in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr onclick=\"journalRedirect(".$row['id'].")\">";
                    echo "<td>" . date("d/m/Y", strtotime($row['journal_date'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['journal_entry']) . "</td>";

                    // Display mood as emoji
                    echo "<td>" .$moods[$row['mood']]. "</td>";
                    
                    echo "</tr>";
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();
                ?>



            </tbody>


        </table>


    </main>
    <script src="history.js"></script>

</body>

</html>