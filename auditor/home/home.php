<?php
    #Access control
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION['id'])) {
        header("Location: ../../index.php");
        exit();
    }
    //check if the user is allowed to view this page
    if ($_SESSION['user_type'] != 4) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>";
        echo "<p>You are not authorized to access this page.</p>";
    
        exit();
    }
    #database connection
    require_once "../../common/db/db-conn.php"; 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient</title>
    <link rel="stylesheet" href="auditor.css">
</head>
<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?>
    </header>
 

<?php
// Query to fetch data for auditors
$sql = "
    SELECT Users.id as t_id, Users.first_name, Users.last_name, COUNT(patient_therapist.patient_id) as patient_count from patient_therapist
    LEFT JOIN Users on Users.id = patient_therapist.therapist_id;
";

$result = $conn->query($sql);

// Display data in a table format
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Therapist Name</th>
                <th>Number of Patients</th>
            </tr>";
    
    // Fetch and display each row of data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['first_name']." ". $row['last_name'] . "</td>
                <td>" . $row['patient_count'] . "</td>
              </tr>";

        //make a request to get all the case type
        $sql = "SELECT case_type, patient_id FROM `patient_therapist` where therapist_id = ".$row['t_id'];
        $statement =  mysqli_stmt_init($conn);

        if($res = mysqli_query($conn, $sql) ){
            if(mysqli_num_rows($res)>0){
                $i = 0;
                while ($case = mysqli_fetch_assoc($res) ){ 
                    if($case['case_type'] == "")
                        $case['case_type'] = "Unidentified";
                    if($case['case_type'] != ""){
                        echo "<tr class='case'>
                                <td>Patient ".$i."</td>
                                <td>Case Type: " . $case['case_type'] . "</td>
                            </tr>";
                            $i++;

                            //make a request for the sessions
                            $j = 0;
                            $sql = "SELECT session_length FROM `sessions` where therapist_id = ".$row['t_id']. " and 
                            patient_id = ".$case['patient_id'];
                            $s =  mysqli_stmt_init($conn);
                            $r = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($r)>0){
                                while ($session = mysqli_fetch_assoc($r) ){ 
                                    echo "<tr class='session'>
                                            <td>Session ".$j."</td>
                                            <td>" . $session['session_length'] . " min </td>
                                        </tr>";
                                        $j++;
                                }
                            }


                    }   

                }
            }
        }

    }
    echo "</table>";
} else {
    echo "No data found.";
}

$conn->close();

?>
</body>
</html>