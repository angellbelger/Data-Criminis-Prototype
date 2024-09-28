<?php 


$hostname = "NULL";
$database = "NULL";
$user = "NULL";
$password = "NULL";
/**/

$mysqli = new mysqli($hostname, $user, $password, $database);

if ($mysqli->connect_errno){
    echo "<p class=\"f\">No connected: (". $mysqli->connect_errno. ") " .$mysqli->connect_error . "</p>";
}


?>