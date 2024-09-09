<?php
include_once __DIR__ . "/../../conf.php"
?>
<link rel="stylesheet" type="text/css" href="<?= $base_url ?>/style.css">
<link rel="stylesheet" type="text/css" href="<?= $base_url ?>/common/navbar/navbar.css">
<nav class="MainNavbar">

    <?php
    //cuurently displaying content based on url
    //will change to access control in further phases

    if (str_contains($_SERVER['REQUEST_URI'], "/patient/")) {
    ?>
        <a href="<?= $base_url ?>patient/home/home.php">
            <p>Home</p>
        </a>
        <a href="<?= $base_url ?>patient/journal/journal.php">
            <p>Journal</p>
        </a>
        <a href="<?= $base_url ?>patient/history/history.php">
            <p>History</p>
        </a>

    <?php
    }
    else if (str_contains($_SERVER['REQUEST_URI'], "/therapist/")) {
    ?>
        <a href="<?= $base_url ?>/therapist/home_page/index.php">
            <p>Home</p>
        </a>
        <a href="<?= $base_url ?>/therapist/groups/groups.php">
            <p>Groups</p>
        </a>
    <?php
    }
    ?>

    <span class="profileContainer">
        <img src="<?= $base_url ?>assets/images/default_profile.svg" id="profileImage">
        <button id="profileSettingsButton" onclick="toggleProfileSettings()"><img src="<?= $base_url ?>assets/images/dropdown.svg" id="profileDropdownImage"></button>

        <div id="logoutContainer">
            <button onclick="redirect('<?= $base_url ?>')">Logout</button>
        </div>
    </span>

    <script src="<?= $base_url ?>/common/navbar/navbar.js"></script>
</nav>