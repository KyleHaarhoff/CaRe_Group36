<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
include_once __DIR__."/../../conf.php";

  
     // Fetch all patients from the database
     global $conn;
     $patients = [];
     $query = "SELECT id, first_name, last_name FROM Users WHERE user_type = 1"; // Assuming 1 is the Patient type
     if ($result = $conn->query($query)) {  
         while ($row = $result->fetch_assoc()) {
             $patients[] = $row;
         }
     } else {
         echo "Error: " . $conn->error;
     }
     
// Query to fetch active groups and their members
$query = "SELECT g.id AS group_id, g.group_name, u.first_name,u.last_name, gm.is_member FROM groups g LEFT JOIN group_members gm ON g.id = gm.group_id LEFT JOIN users u ON gm.user_id = u.id WHERE g.is_active = 1 AND gm.is_member = 1 ORDER BY g.id, u.first_name;";

$result = $conn->query($query);

$groups = [];
// Group data by group_id and populate members
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $groupId = $row['group_id'];
        if (!isset($groups[$groupId])) {
            $groups[$groupId] = [
                'group_name' => $row['group_name'],
                'members' => []
            ];
        }
        $groups[$groupId]['members'][] = $row['first_name']. ' ' . $row['last_name'];
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups</title>
    <link rel="stylesheet" type="text/css" href="<?= $base_url ?>/therapist/groups/groups.css">
</head>
<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?> 
    </header>
    <main>
        <div class="groupComponentContainer shadow rounded">
            <div class="listControlContainer">
                <button class="careButton"  onclick="openGroupManager()">Add Group</button>
                <span class="listControls">
                    <label class="minimumSizeLabel">Minimum Group Size <input type="number" value="0" min="0" id="minCount"></label>
                    <span class="groupFilterContainer"><button class="otherButton" onclick="searchGroups()">Filter</button></span>
                    <input type="text" placeholder="Search.." class="careSearch" onkeyup="searchGroups()" id="groupSearchInput">
                </span>
            </div>
           

            <div class="groupListContainer">
    <?php foreach ($groups as $groupId => $group): ?>
        <div class="groupContainer" id="Group<?= $groupId ?>">
            <div class="groupControl">
                <span class="groupTitle"><?= htmlspecialchars($group['group_name']) ?></span>
                <span>
                    <img class="dropdownIcon" src="<?= $base_url ?>assets/images/dropdown.svg" onclick="toggleDropdown(this, 'group<?= $groupId ?>ContentList')">
                </span>
            </div>
            <div class="dropdownContent" id="group<?= $groupId ?>ContentList">
                <div class="patientList">
                    <?php foreach ($group['members'] as $member): ?>
                        <span><?= htmlspecialchars($member) ?></span>  
                    <?php endforeach; ?>
                </div>
                <div class="groupButtons">
                    <button class="otherButton" onclick="openGroupManager('Group<?= $groupId ?>')">Manage Group</button>
                    <button class="otherButton" onclick="deleteGroup(<?= $groupId ?>)">Delete Group</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        </div>

        <div id="managerCover">
            <div class="groupManagementContainer shadow rounded">
                <div class="managementTitleContainer">
                    <div id="groupIdForUpdate" style="display:none;"></div>
                    <input type="text" id="groupTitleInput" placeholder="Enter the group name...">
                    <div class="rightContentContainer">
                        <button onclick="closeGroupManager()" class="closeManagerButton"><img src="<?= $base_url ?>assets/images/close.svg"></button>
                    </div>
                </div>
                <div class="groupManagementContent">   
                    <div class="groupPatientsContainer rounded">
                        <div class = "groupPatientsControls">
                            <input type="text" value="" class="patientSearch" placeholder="Search group patients..." onkeyup="searchGroupPatients(this)">
                        </div>
                        <div id="groupPatientList">
                        </div>
                    </div>
                    <div class="movePatientButtonsContainer">
                        <button class="rightArrow" onclick="movePatientsRight()"><img src="<?= $base_url ?>assets/images/arrow.svg"></button>
                        <button  class="leftArrow" onclick="movePatientsLeft()"><img src="<?= $base_url ?>assets/images/arrow.svg"></button>
                    </div>
                    <div class="allPatientsContainer rounded">
                        <div class = "allPatientsControls">
                            <input type="text" value="" class="patientSearch" placeholder="Search all patients..." onkeyup="searchAllPatients(this)">
                        </div> 
                        
                        <div id="allPatientList">
                    
                </div>
                    </div>
                    <div class="rightContentContainer countContainer" id="groupCount">Count: 1</div>
                    <div></div>
                    <div class="rightContentContainer countContainer" id="allCount">Count: 2</div>
                    <div></div>
                    <div></div>
                    <div class="rightContentContainer">
                        <button  class="careButton" onclick="confirmSave()">Save</button>
                    </div>
                </div>
            </div>  
        </div>
    </main>
    <?php include "../../common/confirmation/confirmation.php"; ?> 
    <?php include "../../common/notification/notification.php"; ?> 
    <?php include "../../common/warnings/warning.php"; ?> 
    <script src="<?= $base_url ?>/therapist/groups/groups.js"></script>
</body>
</html>

<?php


// Close the connection
$conn->close();
ob_end_flush();
?>