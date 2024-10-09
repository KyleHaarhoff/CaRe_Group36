<?php
include_once __DIR__ . "/../../conf.php";
#Access control
// Check if the user is logged in
if(!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
}
$sql= "SELECT * FROM Users where id = ?;";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);

    mysqli_stmt_execute($stmt);
    if($result = mysqli_stmt_get_result($stmt)) {
        $user=mysqli_fetch_assoc($result);
    }
}

?>
<link rel="stylesheet" type="text/css" href="<?= $base_url ?>/style.css">
<link rel="stylesheet" type="text/css" href="<?= $base_url ?>/common/navbar/navbar.css">
<nav class="MainNavbar">

    <?php
    //will change to access control in further phases
    switch ($_SESSION['user_type'])
    {
    case 1:
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
        break;
    case 2:
    ?>
        <a href="<?= $base_url ?>/therapist/home_page/index.php">
            <p>Home</p>
        </a>
        <a href="<?= $base_url ?>/therapist/groups/groups.php">
            <p>Groups</p>
        </a>
    <?php
        break;
    case 3:
        ?>
            <a href="<?= $base_url ?>/professional/home/home.php">
                <p>Home</p>
            </a>
        <?php
        break;
    }
    ?>
    <span class="profileContainer">

        <?php
        if ($user['profile_image']) {
            // Output the image data
            ?>
            <a  href="<?= $base_url ?>/profile/update-profile.php"><img src="<?= $base_url ?>/profile/user-profile-image.php" id="profileImage"  ></a> 
            <?php
        } else {
            ?>
            <a  href="<?= $base_url ?>/profile/update-profile.php"><img src="<?= $base_url ?>assets/images/default_profile.svg" id="profileImage"></a>
            <?php
        }
        ?>

        
        <div id="logoutContainer">
            <button onclick="redirect('<?= $base_url."?logout=true" ?>')">Logout</button>
        </div>
    </span>

    <script src="<?= $base_url ?>/common/navbar/navbar.js"></script>
</nav>