<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'blogportal';

$conn = new mysqli($host ,$user ,$pass ,$db );

if($conn->connect_error){
  echo "conn error";
}
// else
//   echo"hurray";

?>