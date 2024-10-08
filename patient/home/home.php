<?php
#Access control
session_start();
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}
//check if the user is allowed to view this page
if ($_SESSION['user_type'] != 1) {
    http_response_code(403);
    echo "<h1>403 Forbidden</h1>";
    echo "<p>You are not authorized to access this page.</p>";

    exit();
}
include_once __DIR__ . "/../../conf.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="../../../CaRe_Group36/style.css">

</head>

<body>
    <header>
        <?php include "../../common/navbar/navbar.php" ?>
    </header> 

    <main>
        <div class="container">
            <!-- Affirmation Section -->
            <section class="affirmation">
                <h2 id="affirmation"><?php
                                $sql= "SELECT * FROM Affirmations  where patient_id = ?;";
                                if ($stmt = mysqli_prepare($conn, $sql)) {
                                    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);
            
                                    mysqli_stmt_execute($stmt);
            
                                    if($result = mysqli_stmt_get_result($stmt)) {
                                        if(mysqli_num_rows($result)> 0) {
                                            $row=mysqli_fetch_assoc($result);
                                            echo $row['affirmation'];
                                        }
                                    }
                                }
                            ?></h2>
                <button class="careButton" id="editButton">
                    <img id="editImage" src="../images/edit.png" alt="Edit">
                </button>
            </section>

            <!-- Weekly Goals Section -->
            <section class="weekly-goals">
                <h3>Weekly Goals</h3>
                <ul class="goal-list">
                <?php 

                    $sql= "SELECT * FROM Goals  where user_id = ? and is_completed = 0;";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);

                        mysqli_stmt_execute($stmt);

                        if($result = mysqli_stmt_get_result($stmt)) {
                            if(mysqli_num_rows($result)> 0) {
                                while($row=mysqli_fetch_assoc($result)) {
                                    echo "<li>" .$row["goal_text"]. "</li>";
                                }
                            }
                        }
                    }
                ?>
                </ul>
                <button class="careButton-editGoals" data-target="../goals/goals.php">Edit Goals</button>
            </section>

            <!-- Journal Section -->
            <section class="journal">
                <div class="journal-header">
                    <!-- Add Icons for Date and Status -->
                    <input type="date" id="journal-date" name="journal-date" value="2024-08-09">
                    <select id="affirmation-options" name="affirmation-options">
                        <option value="sad">&#128532 Sad</option>
                        <option value="happy">&#128512 Happy</option>
                        <option value="angry">&#128545 Angry</option>
                    </select>
                    <button class="careButton-writing" data-target="../journal/journal.php">Start Writing!</button>

                </div>

                <!-- Journal Entry Table -->
                <div class="journal-list">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Entry</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql= "SELECT * FROM journal_entries  where patient_id = ? ORDER BY journal_date DESC LIMIT 4;";
                                if ($stmt = mysqli_prepare($conn, $sql)) {
                                    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);
            
                                    mysqli_stmt_execute($stmt);
            
                                    if($result = mysqli_stmt_get_result($stmt)) {
                                        if(mysqli_num_rows($result)> 0) {
                                            while($row=mysqli_fetch_assoc($result)) {
                                                ?>
                                                <tr>
                                                    <td><?= $row['journal_date'] ?></td>
                                                    <td><?php
                                                    if (mb_strlen($row['journal_entry']) > 55) {
                                                        echo mb_substr($row['journal_entry'], 0, 55) . '...';
                                                    } else {
                                                        echo $row['journal_entry'];
                                                    }
                                                    ?></td>
                                                    <td><?= $moods[$row['mood']] ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <button class="careButton-patientHome" onclick="window.location.replace('../history/history.php')">View Full History</button>
            </section>
        </div>
    </main>
    <?php include "../../common/confirmation/confirmation.php"; ?> 
    <?php include "../../common/notification/notification.php"; ?> 
    <script src="home.js"></script>
</body>


</html>