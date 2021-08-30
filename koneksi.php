<?php 

error_reporting(0);

$host = "localhost";
$username = "root";
$password = "";
$database = "dbpus";

$conn = new mysqli($host, $username, $password, $database);

if($conn->connect_error)
{
    die("Connection Failed: " . $conn->connect_error);
}

?>