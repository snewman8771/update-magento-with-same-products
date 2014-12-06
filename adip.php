<?php
error_reporting(E_ALL);
require('connect.php');
$sql = "CREATE TABLE IF NOT EXISTS `ipaddress` (
  `ip` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password1` varchar(100) NOT NULL,
  `databasename` varchar(100) NOT NULL
)";
if(mysqli_query($mysqli, $sql)){
echo "success";
}

if(isset($_POST["address"])){
$ip = $_POST["address"];
$username = $_POST["username"];
$password = $_POST["password"];
$databasename = $_POST["databasename"];
$sql = "INSERT INTO ipaddress (ip, username, password1, databasename)VALUES ('$ip', '$username', '$password', '$databasename')";
if(mysqli_query($mysqli, $sql)){
echo "IP address inserted successfully";
}
else{
echo "error inserting IP address <br>";
echo "Error: " . $sql . "<br>" . $mysqli->error;
error_reporting(-1);
}
}
?>