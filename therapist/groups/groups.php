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
    <body>
        <div class="groupComponentContainer shadow rounded">
            <div class="listControlContainer">
                <button class="careButton">Add Group</button>
                <span class="listControls">
                    <span class="groupFilterContainer">Filter</span>
                    <input type="text" placeholder="Search.." class="careSearch">
                </span>
            </div>
            <div class="groupListContainer">
                <div class="groupContainer" data-groupID="">
                    <div class="groupControl">
                        <span class="groupTitle">Group 1</span>
                        <span>
                            <img class="dropdownIcon vInvert" src="<?= $base_url ?>assets/images/dropdown.svg">
                        </span>
                    </div>
                    <div class="patientList">
                        <span>Jack Ross</span>  
                        <span>Ross Man</span>  
                        <span>Frederick</span>  
                        <span>Somebody</span>  
                        <span>Another Body</span>  
                        <span>Jack Ross Again</span>  
                    </div>
                    <div class="groupButtons">
                        <button class="careButton">Manage Group</button>
                        <button class="careButton">Delete Group</button>
                    </div>
                </div>
                <div class="groupContainer" data-groupID="">
                    <div class="groupControl">
                        <span class="groupTitle">Group 2</span>
                        <span>
                            <img class="dropdownIcon vInvert" src="<?= $base_url ?>assets/images/dropdown.svg">
                        </span>
                    </div>
                    <div class="patientList">
                        <span>Jack Ross</span>  
                        <span>Ross Man</span>  
                        <span>Frederick</span>  
                        <span>Somebody</span>  
                        <span>Another Body</span>  
                        <span>Jack Ross Again</span>  
                    </div>
                    <div class="groupButtons">
                        <button class="careButton">Manage Group</button>
                        <button class="careButton">Delete Group</button>
                    </div>
                </div>
                <div class="groupContainer" data-groupID="">
                    <div class="groupControl">
                        <span class="groupTitle">Group 3</span>
                        <span>
                            <img class="dropdownIcon vInvert" src="<?= $base_url ?>assets/images/dropdown.svg">
                        </span>
                    </div>
                    <div class="patientList">
                        <span>Jack Ross</span>  
                        <span>Ross Man</span>  
                        <span>Frederick</span>  
                        <span>Somebody</span>  
                        <span>Another Body</span>  
                        <span>Jack Ross Again</span>  
                    </div>
                    <div class="groupButtons">
                        <button class="careButton">Manage Group</button>
                        <button class="careButton">Delete Group</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</body>
</html>