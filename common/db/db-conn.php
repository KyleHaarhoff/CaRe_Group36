<?php

define("DB_HOST", "localhost");
define("DB_NAME", "CareGroup36");
define("DB_USER", "dbadmin");
define("DB_PASS", "");

$conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    // Something went wrong...
    echo "Error: Unable to connect to database.<br>";
    echo "Debugging error: " . mysqli_connect_error() . "<br>";
    echo "Debugging error: " . mysqli_connect_error() . "<br>";
    exit;
}
