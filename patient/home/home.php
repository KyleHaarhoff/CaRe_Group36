<?php

    include_once __DIR__."/../../conf.php"
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
    <section class="affirmation">
    <h2>"This is a daily affirmation for the patient"</h2>
    <button id="edit-affirmation" onclick="editAffirmation()"></button>
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
    </main>
</body>
</html>