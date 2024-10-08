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
    <?php include "../../common/navbar/navbar.php"; 
    $journal_id = htmlspecialchars($_GET['id']);?> 
</header>
<?php
$sql= "SELECT * FROM journal_entries  where id = ?;";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $journal_id);

    mysqli_stmt_execute($stmt);

    if($result = mysqli_stmt_get_result($stmt)) {
        if(mysqli_num_rows($result)> 0) {
            $row=mysqli_fetch_assoc($result);
        }
    }
}
?>
<div class="container shadow rounded">
    <div class="journal-form">
        <h2>Patient Journal</h2>
        <form class="classform">
            <div class="journal-info">
                <label for="journal-date">Date:</label>
                <input type="date" id="journal-date" name="journal-date" readonly  value="<?= $row['journal_date'] ?>">
                
                <label for="hours-slept">No. of Hours Slept:</label>
                <input type="number" id="hours-slept" name="hours-slept" readonly  value="<?= $row['hours_slept'] ?>"> 
                
                <label for="mood">Mood:</label>
                <select id="mood" name="mood" disabled> 
                    <option value="happy" <?php if($row['mood']=="happy"){echo " selected";} ?>>&#128522; Happy</option>
                    <option value="neutral" <?php if($row['mood']=="neutral"){echo " selected";} ?>>&#128528; Neutral</option>
                    <option value="sad" <?php if($row['mood']=="sad"){echo " selected";} ?>>&#128546; Sad</option>
                    <option value="angry" <?php if($row['mood']=="angry"){echo " selected";} ?>>&#128545; Angry</option>
                    <option value="excited" <?php if($row['mood']=="excited"){echo " selected";} ?>>&#128513; Excited</option>
                    <option value="tired" <?php if($row['mood']=="tired"){echo " selected";} ?>>&#128564; Tired</option>
                    <option value="anxious" <?php if($row['mood']=="anxious"){echo " selected";} ?>>&#128552; Anxious</option>
                </select>

                <label for="meals-eaten">No. of Meals Eaten:</label>
                <input type="number" id="meals-eaten" name="meals-eaten" readonly  value="<?= $row['meals_eaten'] ?>">

                <label for="exercise">Exercise:</label>
                <input type="checkbox" id="exercise" name="exercise" disabled  value="<?= $row['exercise'] ?>" <?php
                    if($row['exercise']){echo " checked";}
                ?>>
            </div>

            
            <textarea id="journal-entry" name="journal-entry" rows="5" placeholder="Insert journal here..." disabled><?= $row['journal_entry'] ?></textarea>

        </form>
        <?php
            $sql= "SELECT journal_images.id as id FROM `journal_images` LEFT JOIN journal_entries on journal_id = journal_entries.id WHERE journal_id = ?;";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, 'i', $journal_id);
            
                mysqli_stmt_execute($stmt);
                $images = mysqli_stmt_get_result($stmt);
                if($images) {
                    if(mysqli_num_rows($images)> 0) {
                        ?>
                        <div id="images">
                            <?php
                            while($row=mysqli_fetch_assoc($images)) {
                                ?>
                                    <img src="journal-image.php?id=<?=$row['id']?>">
                                <?php
                            }
                            ?>
                        
                        </div>
                        <?php
                    }
                }
            }

            

        ?>
    </div>
</div>
<?php

?>


<script src="journal-writing.js"></script>

</body>
</html>
