<?php
$base_url = "/www/CaRe_Group36/";
$patient_view_page = "/www/CaRe_Group36/therapist/patient_view_page/patient_view_page.php";

// Include the database connection
include_once __DIR__ . '/common/db/db-conn.php';


//key value pairs for mood to emojis
$moods = [];
$moods["happy"] = "&#128522";  
$moods["neutral"] = "&#128528";  
$moods["sad"] = "&#128546";  
$moods["angry"] = "&#128545";  
$moods["excited"] = "&#128513";  
$moods["tired"] = "&#128564";  
$moods["anxious"] = "&#128552";  

?>