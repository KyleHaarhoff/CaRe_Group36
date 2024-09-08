<?php

    include_once __DIR__."/../../conf.php"
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
                    <span class="groupFilterContainer"><button class="otherButton">Filter</button></span>
                    <input type="text" placeholder="Search.." class="careSearch" onchange="searchGroups(this)">
                </span>
            </div>
            <div class="groupListContainer">
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
                            <input type="text" class="patientSearch" placeholder="Search group patients..." onchange="searchGroupPatients(this)">
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
                            <input type="text"  class="patientSearch" placeholder="Search all patients..." onchange="searchAllPatients(this)">
                        </div> 
                        <div id="allPatientList">
                            <span data-id="1" onclick="toggleSelected(this)">Jack Ross</span>  
                            <span data-id="2" onclick="toggleSelected(this)">Ross Mars</span>  
                            <span data-id="3" onclick="toggleSelected(this)">Frederick</span>  
                            <span data-id="4" onclick="toggleSelected(this)">Somebody</span>  
                            <span data-id="5" onclick="toggleSelected(this)">Another Body</span>  
                            <span data-id="6" onclick="toggleSelected(this)">Jack Ross Again</span>
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