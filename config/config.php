<?php

// To connect to the database
$host = "bikowq677thdrnuxwsan-mysql.services.clever-cloud.com";
$username = "uvzfr3yx7czbfwrb";
$password = "3NPkt1kfWOReDtBHOwln";
$database = "bikowq677thdrnuxwsan";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>