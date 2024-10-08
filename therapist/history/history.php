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
                $sql = "SELECT journal_date, journal_entry, mood FROM journal_entries WHERE patient_id = ? ORDER BY journal_date DESC";

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
                    echo "<tr onclick=\"journalRedirect()\">";
                    echo "<td>" . date("d/m/Y", strtotime($row['journal_date'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['journal_entry']) . "</td>";

                    // Display mood as emoji
                    switch ($row['mood']) {
                        case 'happy':
                            echo "<td>&#128522;</td>";
                            break;
                        case 'neutral':
                            echo "<td>&#128528;</td>";
                            break;
                        case 'sad':
                            echo "<td>&#128546;</td>";
                            break;
                        case 'angry':
                            echo "<td>&#128545;</td>";
                            break;
                        default:
                            echo "<td>&#128528;</td>"; // Default neutral face
                            break;
                    }
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