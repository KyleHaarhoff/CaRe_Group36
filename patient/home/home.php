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

</head>

<body>
    <header>
        <?php
        include "../../common/navbar/navbar.php"
        ?>
    </header>
    <main>
        <div class="container">
            <section class="affirmation">
                <h2>"This is a daily affirmation for the patient"</h2>
                <button id="edit-affirmation" onclick="editAffirmation()">Edit</button>
            </section>

            <section class="weekly-goals">
                <h3>Weekly Goals</h3>
                <ul>
                    <li>This is an example of a weekly goal for the patient</li>
                    <li>Here is another goal</li>
                    <li>One more</li>
                </ul>
                <button id="edit-goals">Edit Goals</button>
            </section>

            <section class="journal">
                <div class="journal-header">

                    <input type="date" id="journal-date" name="journal-date" min="2023-01-01" max="2023-12-31" value="2023-08-27">
                    <select id="affirmation-options" name="affirmation-options">
                        <option value="sad">Sad</option>
                        <option value="happy">Happy</option>
                        <option value="angry">Angry</option>
                    </select>
                    <button id="start-writing">Start Writing!</button>
                </div>

                <div class="journal-list">
                    <table border="1">
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
                                <td>Sad</td>
                            </tr>
                            <tr>
                                <td>07/08/2024</td>
                                <td>This is the start of a journal entry. It will cut off after...</td>
                                <td>Happy</td>
                            </tr>
                            <tr>
                                <td>06/08/2024</td>
                                <td>This is the start of a journal entry. It will cut off after...</td>
                                <td>Happy</td>
                            </tr>
                            <tr>
                                <td>05/08/2024</td>
                                <td>This is the start of a journal entry. It will cut off after...</td>
                                <td>Happy</td>
                            </tr>

                        </tbody>
                    </table>

                </div>

                <button id="view-history">View Full History</button>
            </section>
        </div>
    </main>
</body>
<script src="home.js"></script>

</html>