<?php
$mysqli = new mysqli('127.0.0.1','root','root','cobaltstrike');
$ip = $_SERVER['REMOTE_ADDR'];
$query = "SELECT * FROM user WHERE externalIP='$ip'";
$result = $mysqli->query($query);

if (mysqli_num_rows($result) > 0) {
  echo "OK";
}
else { 
  echo "NO";
}
?>