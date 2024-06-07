<?php

$hostname = "localhost";
$username = "root";
$password = "L@mpashae#22";
$database = "project_splm";


$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}