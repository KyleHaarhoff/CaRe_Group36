<?php
    #Access control
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION['id'])) {
        header("Location: ../../index.php");
        exit();
    }
    //check if the user is allowed to view this page
    if ($_SESSION['user_type'] != 2) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>";
        echo "<p>You are not authorized to access this page.</p>";

        exit();
    }                  
                            
    $patient_id = htmlspecialchars($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient View Page</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../common/navbar/navbar.css">
    <link rel="stylesheet" href="../patient_view_page/view_page.css">
</head>
<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; 
        
        $sql= "SELECT * FROM `patient_therapist` LEFT JOIN users on patient_therapist.patient_id = users.id 
        where patient_therapist.therapist_id = ? and patient_therapist.patient_id = ?;";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['id'],$patient_id);

            mysqli_stmt_execute($stmt);
            if($result = mysqli_stmt_get_result($stmt)) {
                $patient=mysqli_fetch_assoc($result);
        }
    }
        
        
        ?>
    </header>

    <main>
        <input type="hidden" value="<?= $patient_id ?>" name="patient_id" id="patient_id">
        <div class="container">
            <div class="profile-journal">
                <div class="profile">
                    <?php
                    if ($patient['profile_image']) {
                        // Output the image data
                        ?>
                        <img src="patient_image.php?patient_id=<?= $patient['patient_id'] ?>" alt="Profile Picture" class="profile-img">
                        <?php
                    } else {
                        ?>
                        <img src="../../assets/images/default_profile.svg" alt="Profile Picture" class="profile-img">
                        <?php
                    }
                    ?>
                    <h1><?= $patient['first_name'] . ' '. $patient['last_name']?></h1>
                </div>
                <section class="journal">
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
                                    <td>&#128512;</td>
                                </tr>
                                <tr>
                                    <td>07/08/2024</td>
                                    <td>This is the start of a journal entry. It will cut off after...</td>
                                    <td>&#128512;</td>
                                </tr>
                                <tr>
                                    <td>06/08/2024</td>
                                    <td>This is the start of a journal entry. It will cut off after...</td>
                                    <td>&#128512;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="../../therapist/history/history.php">
                    <button class="viewHistory">View Full History</button>
                    </a>
                </section>
            </div>
            <div class="main-content">
                <div class="grid-content">
                    <div class="patient-details">
                    <h2>General Patient Details</h2>
                    <p>Age: <?= $patient['age'] ?></p>
                    <p>Email: <?= $patient['email'] ?></p>
                    <p>Phone Number: <?= $patient['phone_number'] ?></p>
                    <p>Age: <?= $patient['age'] ?></p>
                    <p>Gender: <?= $patient['gender'] ?></p>
                    <?php
                    mysqli_free_result($result);
                    ?>
                        
                    </div>
                    <div>
                        <h2>Consultations</h2>
                        <div class="consultation-table-container">
                        <table class="consultation-table">
                        <tbody>
                            <tr>
                                <th>Date</th>
                                <th>Duration</th>
                            </tr>
                            <?php

                            $sql= "SELECT * FROM sessions where p_id = ? and id = ? ORDER BY session_date DESC;";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, 'ii', $patient_id,$_SESSION['id']);
        
                                mysqli_stmt_execute($stmt);
        
                                if($result = mysqli_stmt_get_result($stmt)) {
                                if(mysqli_num_rows($result)> 0) {
                                    while($row=mysqli_fetch_assoc($result)) {
                                        ?>
                                            <tr>
                                                <td><?= $row['session_date']?></td>
                                                <td><?= $row['session_length']?> min</td>
                                            </tr>
                                        <?php
                                    }
                                    mysqli_free_result($result);
                                }
                                }
                            }
                            

                            ?>
                            </tbody>
                        </table>
                        </div>
                        <div class="buttonContainer">
                            <button class="addButton" onclick="openAddConsultation()">Add Consultation</button>
                        </div>
                        <div>
                            Case Type: <input type="text" name="case_type" value="<?= $patient['case_type']?>" id="case_type">
                        </div>
                    </div>
                </div>
                <div class="therapist-notes">
                    <h2>Therapist Notes</h2>
                    <textarea name="note" id="note"><?= $patient['note'] ?></textarea>
                    <div class="actions"></div>
                    
                    
                    <label for="followup">Requires Follow Up</label>
                    <input type="checkbox" id="followup" name="followup" <?php
                     if($patient['requires_followup'] == "Yes"){
                        echo "checked";
                     }
                    ?>><br>
                    
                    <div class="buttonContainer">
                        <button class="viewHistory" onclick="saveInfo()">Save</button>
                    </div>
                    <br>
                    </div>
                </div>
            </div>
        </div>

        <div class="add-consultation-container shadow rounded" id="add-consultation-container">
            <input type="number" min="5" name="session_length" id="session_length" value="60"> <span>min</span>
            <div>
                <button class="formButton"  onclick="addConsultation()">Add</button>
                <button class="formButton" onclick="closeAddConsultation()">Cancel</button>
            </div>
        </div>
    </main>
    <?php include "../../common/confirmation/confirmation.php"; ?> 
    <?php include "../../common/notification/notification.php"; ?> 
    <script src="script.js"></script>
    <script src="../../common/navbar/navbar.js"></script>
</body>
</html>
