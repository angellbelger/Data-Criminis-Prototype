<?php 


$hostname = "localhost";
$database = "bbc_stock";
$user = "root";
$password = "";
/*7CN3m[^dde)u*/

$mysqli = new mysqli($hostname, $user, $password, $database);

if ($mysqli->connect_errno){
    echo "<p class=\"f\">No connected: (". $mysqli->connect_errno. ") " .$mysqli->connect_error . "</p>";
}


?>