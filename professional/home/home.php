<?php
    #Access control

    #database connection
    require_once "../../common/db/db-conn.php"; 
    

    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Staff Home Page</title>
    <link rel="stylesheet" href="home.css">

</head>

<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?>
    </header>
    <main class="main_container">
        <div class="user_list_header">
            <h2>User List</h2>
            <div class="controls">
                <label for="user_type"> Filter: </label>
                <select id="user_type" onchange="filterTable()">
                    <option value="All">All</option>
                    <option value="Patient">Patient</option>
                    <option value="Therapist">Therapist</option>
                    <option value="Professional">Professional Staff</option>
                    <option value="Auditor">Auditor</option>
                </select>
                <input type="search" placeholder="Search..." class="search-box" id="inp" onkeyup="myFunction()">
            </div>
        </div>

        <table id="user_table" class="user_table">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>User Type</th>
                    <th class="last_column">Created On</th>
                </tr>
            </thead>
            <tbody>
<?php

    $sql = "SELECT users.first_name, users.last_name, users.added, usertype.type from users 
    LEFT JOIN usertype ON users.user_type = usertype.id;" ;
    $statement =  mysqli_stmt_init($conn);

    if($result = mysqli_query($conn, $sql) ){
        if(mysqli_num_rows($result)>0){
            while ($row = mysqli_fetch_assoc($result) ){ 
                
                #extract the date from the datetime
                $dt = new DateTime($row['added']);
                $date = $dt->format('d/m/Y');

                ?>
                <tr data-user-type="<?= $row['type'] ?>">
                    <td>
                        <a class="user_names" href="<?= $patient_view_page ?>"><?= $row['first_name'] ?> <?= $row['last_name'] ?></a>
                    </td>
                    <td><?= $row['type'] ?>
                    </td>
                    <td><?= $date?></td>
                </tr>
                <?php
            }
        }
    }
    mysqli_free_result($result);
    mysqli_close($conn);
?>
                
            </tbody>


        </table>
        <a class="add-user" href="<?= $base_url ?>/professional/add-user/add-user.php">Add User</a> 


    </main>
    <?php include "../../common/notification/notification.php"; 
    ?>
    

    <script

        src="<?= $base_url ?>/professional/home/home.js">
    </script>

</body>

</html>