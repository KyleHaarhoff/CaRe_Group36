

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

                <?php 

                    $sql= "SELECT * FROM Goals  where user_id = ?;";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);

                        mysqli_stmt_execute($stmt);

                        if($result = mysqli_stmt_get_result($stmt)) {
                        if(mysqli_num_rows($result)> 0) {
                            while($row=mysqli_fetch_assoc($result)) {
                                if ($row["is_completed"]){
                                    echo '<tr class="hidden" data-id="'.$row["id"].'">';
                                }
                                else{
                                    echo '<tr data-id="'.$row["id"].'">';
                                }


                                ?>
                                    <td><input type="checkbox" <?php
                                        if ($row["is_completed"]){
                                            echo 'checked';
                                        } ?> class="goalCheckbox" onclick="makeEditable(this)"></td>
                                    <td><input readonly type="text" value = "<?= $row["goal_text"] ?>" class="goalTitle"></td>
                                    <td><button class="tableButton" onclick="makeEditable(this)">Edit</button></td>
                                    <td><button class="tableButton" onclick="confirmRemoveGoal(this)">Remove</button></td>
                                <?php

                            }
                            echo"</tr>";
                            mysqli_free_result($result);
                        }
                        }
                    }
                    mysqli_close($conn);
                    ?>

                    
                </tbody>


            </table>
            </div>
            <div class="rightContentContainer">
                <button class="careButton" onclick="window.location.replace('../home/home.php')">Back</button>
                <button class="careButton"  onclick="addGoal()">Add Goal</button>
            </div>
        </div>
        
        
    </main>
    <?php include "../../common/confirmation/confirmation.php"; ?> 
    <?php include "../../common/notification/notification.php"; ?> 
    <script src="<?= $base_url ?>/patient/goals/goals.js"></script>
</body>
</html>