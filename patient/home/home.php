<?php

include_once __DIR__ . "/../../conf.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="../../../CaRe_Group36/style.css">

</head>

<body>
    <!-- <header>
        <?php include "../../common/navbar/navbar.php" ?>
    </header> -->

    <main>
        <div class="container">
            <!-- Affirmation Section -->
            <section class="affirmation">
                <h2 id="affirmation">This is a daily affirmation for the patient</h2>
                <button class="careButton" id="editButton">
                    <img id="editImage" src="../images/edit.png" alt="Edit">
                </button>
            </section>

            <!-- Weekly Goals Section -->
            <section class="weekly-goals">
                <h3>Weekly Goals</h3>
                <ul>
                    <li>This is an example of a weekly goal for the patient</li>
                    <li>Here is another goal</li>
                    <li>One more</li>
                </ul>
                <button class="careButton">Edit Goals</button>
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
                    <button class="careButton">Start Writing!</button>
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
                            <tr>
                                <td>08/08/2024</td>
                                <td>This is the start of a journal entry. It will cut off after...</td>
                                <td>&#128512</td>
                            </tr>
                            <tr>
                                <td>07/08/2024</td>
                                <td>This is the start of a journal entry. It will cut off after...</td>
                                <td>&#128512</td>
                            </tr>
                            <tr>
                                <td>06/08/2024</td>
                                <td>This is the start of a journal entry. It will cut off after...</td>
                                <td>&#128512</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button class="viewHistory">View Full History</button>
            </section>
        </div>
    </main>
    <script src="home.js"></script>
</body>


</html>