<?php
    include_once __DIR__."/../../conf.php"
?>
<link rel="stylesheet" type="text/css" href="<?= $base_url ?>/style.css">
<link rel="stylesheet" type="text/css" href="<?= $base_url ?>/common/navbar/navbar.css">
<nav class="MainNavbar">

    <?php 
        //cuurently displaying content based on url
        //will change to access control in further phases

        if (str_contains($_SERVER['REQUEST_URI'], "patient"))
        {
        ?>
            <a href= "<?= $base_url ?>patient/home/home.php"><p>Home</p></a>
            <a><p>Journal</p></a>
            <a><p>History</p></a>

        <?php 
        }
        if (str_contains($_SERVER['REQUEST_URI'], "therapist"))
        {
        ?>
            <a href= "<?= $base_url ?>patient/therapist/home.php"><p>Home</p></a>
            <a><p>Journal</p></a>
            <a><p>History</p></a>
        <?php
        }
    ?>
</nav>