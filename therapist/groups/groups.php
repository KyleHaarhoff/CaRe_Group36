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
                    <input type="text" placeholder="Search.." class="careSearch">
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
                                <span>Jack Ross</span>  
                                <span>Ross Mars</span>  
                                <span>Frederick</span>  
                                <span>Somebody</span>  
                                <span>Another Body</span>  
                                <span>Jack Ross Again</span>  
                            </div>
                            <div class="groupButtons">
                                <button class="otherButton" onclick="openGroupManager(this)">Manage Group</button>
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
                                <span>Jack Ross</span>  
                                <span>Ross Mars</span>  
                                <span>Frederick</span>  
                                <span>Somebody</span>  
                                <span>Another Body</span>  
                                <span>Jack Ross Again</span>  
                            </div>
                            <div class="groupButtons">
                                <button class="otherButton"  onclick="openGroupManager()">Manage Group</button>
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
                                <span>Jack Ross</span>  
                                <span>Ross Mars</span>  
                                <span>Frederick</span>  
                                <span>Somebody</span>  
                                <span>Another Body</span>  
                                <span>Jack Ross Again</span>  
                            </div>
                            <div class="groupButtons">
                                <button class="otherButton"  onclick="openGroupManager()">Manage Group</button>
                                <button class="otherButton" onclick="deleteGroup('Group3')">Delete Group</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div id="managerCover">
            <div class="groupManagementContainer shadow rounded">
                <div class="managementTitleContainer">
                    <input type="text" class="groupTitleInput" placeholder="Enter the group name...">
                    <div class="rightContentContainer">
                        <button onclick="closeGroupManager()" class="closeManagerButton"><img src="<?= $base_url ?>assets/images/close.svg"></button>
                    </div>
                </div>
                <div class="groupManagementContent">   
                    <div class="groupPatientsContainer rounded">
                        <div class = "groupPatientsControls">
                            <button class="otherButton">Filter</button>
                            <input type="text" class="patientSearch">
                        </div>
                        <div class="groupPatientList">
                            <span onclick="toggleSelected(this)">Jack Ross</span> 
                        </div>
                    </div>
                    <div class="movePatientButtonsContainer">
                        <button class="rightArrow"><img src="<?= $base_url ?>assets/images/arrow.svg"></button>
                        <button  class="leftArrow"><img src="<?= $base_url ?>assets/images/arrow.svg"></button>
                    </div>
                    <div class="allPatientsContainer rounded">
                        <div class = "allPatientsControls">
                            <button class="otherButton">Filter</button>
                            <input type="text"  class="patientSearch">
                        </div> 
                        <div class="allPatientList">
                            <span onclick="toggleSelected(this)">Jack Ross</span>  
                            <span onclick="toggleSelected(this)">Ross Mars</span>  
                        </div>
                    </div>
                    <div class="rightContentContainer countContainer">Count 1</div>
                    <div></div>
                    <div class="rightContentContainer countContainer">Count 2</div>
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