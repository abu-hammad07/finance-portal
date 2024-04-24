<?php

// ------ (Localhost) Server ------ //
$server = "localhost";
$username = "root";
$password = "";
$db = "finance-portal";

$conn = mysqli_connect($server, $username, $password, $db);

if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}

