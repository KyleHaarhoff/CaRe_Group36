<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapist Home Page</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?>
    </header>
    <main class="main_container">
        <div class="patient_list_header">
            <h2>Patient List</h2>
            <div class="controls">
                <label for="journal_status"> Filter: </label>
                <select id="journal_status" onchange="filterTable()">
                    <option value="All">All</option>
                    <option value="Unread">Unread</option>
                    <option value="Up to date">Up to Date</option>
                </select>
                <input type="search" placeholder="Search..." class="search-box" id="inp" onkeyup="myFunction()">
            </div>
        </div>



        <!-- <button class="add-patient-btn">Add Patients</button> -->



        <?php
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "caregroup36";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * From patients";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table id='patient_table' class='patient_table'>
            <thead>";
            echo "<tr>";
            echo "<th>Patient Name</th>";
            echo "<th>Journal Status</th>";
            echo "<th>Requires Follow-up</th>";
            echo "<th class='last_column'>Created On</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = $result->fetch_assoc()) {

                echo "<tr>";
                echo "<td><a class='patient_names' href='patient_view_page/patient_view_page.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</a></td>";
                echo "<td>" . ($row['created_on']) . "</td>";

                echo "<td>" . htmlspecialchars($row['requires_followup']) . "</td>";
                echo "<td>" . date("d/m/Y", strtotime($row['created_on'])) . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No patient data found</p>";
        }
        $conn->close();


        ?>
    </main>

    <script

        src="<?= $base_url ?>/therapist/home_page/script.js">
    </script>

</body>

</html>