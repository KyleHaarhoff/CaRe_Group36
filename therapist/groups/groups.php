<?php

    
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

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted data
    $data = json_decode(file_get_contents('php://input'), true);
    $groupName = $data['groupName'];
    $selectedPatients = $data['selectedPatients'];

    // Check if group name is provided
    if (empty($groupName)) {
        echo json_encode(['success' => false, 'message' => 'Group name is required.']);
        exit;
    }

    // Check if any patients are selected
    if (empty($selectedPatients)) {
        echo json_encode(['success' => false, 'message' => 'At least one patient must be selected.']);
        exit;
    }

    // Insert group name into groups table
    $stmt = $conn->prepare("INSERT INTO groups (group_name, is_active) VALUES (?, ?)");
    $isActive = 1; // Assuming active by default
    $stmt->bind_param("si", $groupName, $isActive);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
        exit;
    }

    // Get the last inserted group ID
    $groupId = $conn->insert_id;

    // Insert each selected patient into group_members table
    foreach ($selectedPatients as $patientId) {
        $stmt = $conn->prepare("INSERT INTO group_members (group_id, user_id, created_by, created_date) VALUES (?, ?, ?, ?)");
        $createdBy = 'admin'; // Replace with the actual username or session data
        $createdDate = date('Y-m-d');
        $stmt->bind_param("iiss", $groupId, $patientId, $createdBy, $createdDate);
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => $stmt->error]);
            exit;
        }
    }

    // Respond with success message
    echo json_encode(['success' => true]);
} else {
    // If not a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['group_id'])) {
        $group_id = intval($_POST['group_id']);
        
        // Update the is_active flag to false for the correct group ID
        $query = "UPDATE groups SET is_active = 0 WHERE id = ?";
        
        // Prepare the statement
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $group_id);
            
            if ($stmt->execute()) {
                // Return success response
                echo json_encode(["status" => "success"]);
            } else {
                // Return failure response
                echo json_encode(["status" => "error", "message" => "Failed to delete group."]);
            }

            $stmt->close();
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Group ID not provided."]);
    }
}
// Close the connection
$conn->close();
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
            <!-- <div class="groupListContainer">
                <div class="groupContainer" id="Group1">
                    <div class="groupControl">
                        <span class="groupTitle">Group 1</span>
                        <span>
                            <img class="dropdownIcon" src="<?= $base_url ?>assets/images/dropdown.svg"  onclick="toggleDropdown(this, 'group1ContentList')">
                        </span>
                    </div>
                        <div class="dropdownContent" id="group1ContentList">
                            <div class="patientList">
                                <span data-id="1">Jack Ross</span>  
                                <span data-id="2">Ross Mars</span>  
                                <span data-id="3">Frederick</span>  
                                <span data-id="4">Somebody</span>  
                            </div>
                            <div class="groupButtons">
                                <button class="otherButton" onclick="openGroupManager('Group1')">Manage Group</button>
                                <button class="otherButton" onclick="deleteGroup('Group1')">Delete Group</button>
                            </div>
                        </div>
                </div>
                <div class="groupContainer" id="Group2">
                    <div class="groupControl">
                        <span class="groupTitle">Group 2</span>
                        <span>
                            <img class="dropdownIcon" src="<?= $base_url ?>assets/images/dropdown.svg" onclick="toggleDropdown(this, 'group2ContentList')">
                        </span>
                    </div>
                        <div class="dropdownContent" id="group2ContentList">
                            <div class="patientList">
                                <span data-id="4">Somebody</span>  
                                <span data-id="5">Another Body</span>  
                                <span data-id="6">Jack Ross Again</span> 
                            </div>
                            <div class="groupButtons">
                                <button class="otherButton"  onclick="openGroupManager('Group2')">Manage Group</button>
                                <button class="otherButton" onclick="deleteGroup('Group2')">Delete Group</button>
                            </div>
                        </div>
                </div>
                <div class="groupContainer" id="Group3">
                    <div class="groupControl">
                        <span class="groupTitle">Group 3</span>
                        <span>
                            <img class="dropdownIcon" src="<?= $base_url ?>assets/images/dropdown.svg" onclick="toggleDropdown(this, 'group3ContentList')">
                        </span>
                    </div>
                        <div class="dropdownContent" id="group3ContentList">
                            <div class="patientList">
                                <span data-id="1">Jack Ross</span>  
                                <span data-id="2">Ross Mars</span>  
                                <span data-id="6">Jack Ross Again</span>
                            </div>
                            <div class="groupButtons">
                                <button class="otherButton"  onclick="openGroupManager('Group3')">Manage Group</button>
                                <button class="otherButton" onclick="deleteGroup('Group3')">Delete Group</button>
                            </div>
                        </div>
                </div>
            </div> -->

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
                        <!-- <div id="allPatientList">
                            <span data-id="1" onclick="toggleSelected(this)">Jack Ross</span>  
                            <span data-id="2" onclick="toggleSelected(this)">Ross Mars</span>  
                            <span data-id="3" onclick="toggleSelected(this)">Frederick</span>  
                            <span data-id="4" onclick="toggleSelected(this)">Somebody</span>  
                            <span data-id="5" onclick="toggleSelected(this)">Another Body</span>  
                            <span data-id="6" onclick="toggleSelected(this)">Jack Ross Again</span>
                        </div> -->
                        <div id="allPatientList">
                    <?php foreach($patients as $patient): ?>
                        <span data-id="<?= $patient['id'] ?>" onclick="toggleSelected(this)">
                            <?= htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']) ?>
                        </span>
                    <?php endforeach; ?>
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
    <script src="<?= $base_url ?>/therapist/groups/groups.js"></script>
</body>
</html>