<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href="journal-writing.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Journal</title>
</head>
<body>
<header>
    <?php include "../../common/navbar/navbar.php"; ?> 
</header>

<div class="container shadow rounded">
    <div class="journal-form">
        <h2>Patient Journal</h2>
        <form class="classform">
            <div class="journal-info">
                <label for="journal-date">Date:</label>
                <input type="date" id="journal-date" name="journal-date" readonly  value="2024-08-08">
                
                <label for="hours-slept">No. of Hours Slept:</label>
                <input type="number" id="hours-slept" name="hours-slept" readonly value="7"> 
                
                <label for="mood">Mood:</label>
                <select id="mood" name="mood" disabled> 
                    <option value="happy">&#128522; Happy</option>
                    <option value="neutral">&#128528; Neutral</option>
                    <option value="sad">&#128546; Sad</option>
                    <option value="angry" selected>&#128545; Angry</option>
                    <option value="excited">&#128513; Excited</option>
                    <option value="tired">&#128564; Tired</option>
                    <option value="anxious">&#128552; Anxious</option>
                </select>

                <label for="meals-eaten">No. of Meals Eaten:</label>
                <input type="number" id="meals-eaten" name="meals-eaten" readonly  value="3">

                <label for="exercise">Exercise:</label>
                <input type="checkbox" id="exercise" name="exercise" disabled>
            </div>

            
            <textarea id="journal-entry" name="journal-entry" rows="5" placeholder="Insert journal here..." disabled>The journal entry</textarea>

        </form>
    </div>
</div>

</body>
</html>
