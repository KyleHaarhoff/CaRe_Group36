

<?php

    include_once __DIR__."/../../conf.php";
require_once "../../common/db/db-conn.php";
   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goals</title>
    <link rel="stylesheet" type="text/css" href="<?= $base_url ?>/patient/goals/goals.css">
</head>
<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?> 
    </header>
    <main>

  
        <div class="goalsTableContainer shadow rounded">
        <div class="minHeightContainer">
            <table id="goalsTable">
                <thead>
                    <tr>
                        <th>Completed</th>
                        <th>Goal Title</th>
                        <th colspan="2"><button class="tableButton" onclick="toggleHidden()" id="toggleHiddenButton">Show Completed</button></th>
                        
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td><input type="checkbox" class="goalCheckbox" onclick="makeEditable(this)"></td>
                        <td><input readonly type="text" value = "5km of running" class="goalTitle"></td>
                        <td><button class="tableButton" onclick="makeEditable(this)">Edit</button></td>
                        <td><button class="tableButton" onclick="confirmRemoveGoal(this)">Remove</button></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="goalCheckbox" onclick="makeEditable(this)"></td>
                        <td><input readonly type="text" value = "Don't eat fast food" class="goalTitle"></td>
                        <td><button class="tableButton" onclick="makeEditable(this)">Edit</button></td>
                        <td><button class="tableButton" onclick="confirmRemoveGoal(this)">Remove</button></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="goalCheckbox" onclick="makeEditable(this)"></td>
                        <td><input readonly type="text" value = "Go to bed by 10pm each day this week" class="goalTitle"></td>
                        <td><button class="tableButton" onclick="makeEditable(this)">Edit</button></td>
                        <td><button class="tableButton" onclick="confirmRemoveGoal(this)">Remove</button></td>
                    </tr>
                    <tr class="hidden">
                        <td><input type="checkbox" checked class="goalCheckbox" onclick="makeEditable(this)"></td>
                        <td><input readonly type="text" value = "Finish this page" class="goalTitle"></td>
                        <td><button class="tableButton" onclick="makeEditable(this)">Edit</button></td>
                        <td><button class="tableButton" onclick="confirmRemoveGoal(this)">Remove</button></td>
                    </tr>
                </tbody>


            </table>
            </div>
            <div class="rightContentContainer">
                <button class="careButton" onclick="window.location.replace('../home/home.php')">Back</button>
                <button class="careButton"  onclick="addGoal()">Add Goal</button>
            </div>
        </div>
        <?php 

$sql= "SELECT user_id, goal_text FROM Goals;";

if($result=mysqli_query($conn,$sql)) {
if(mysqli_num_rows($result)> 0) {
    echo "<ul>";
    while($row=mysqli_fetch_assoc($result)) {
        echo "<li><p>" . $row["user_id"] . ", goals:" . $row["goal_text"]
        . "</p></li>";
    }
    echo"</ul>";
    mysqli_free_result($result);
}
}
mysqli_close($conn);
?>
        
    </main>
    <?php include "../../common/confirmation/confirmation.php"; ?> 
    <?php include "../../common/notification/notification.php"; ?> 
    <script src="<?= $base_url ?>/patient/goals/goals.js"></script>
</body>
</html>