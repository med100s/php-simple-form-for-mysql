<?php

require_once('./classes/inserter.php');

$servername = "localhost";
$dbusername = "admin";
$dbpassword = "admin";
$dbname = "test";
$dbsubname = "myguests2";

$name = $_POST['name'];
$mail = $_POST['mail'];
$Homepage = $_POST['Homepage'];
$Text = $_POST['Text'];


$dbInserter = new dbInserter($servername, $dbusername, $dbpassword, $dbname, $dbsubname); 
// $dbInserter->Checkcaptcha();
$dbInserter->Connect();
$dbInserter->InsertIntodb($name, $mail, $Homepage, $Text);
$dbInserter->CloseConection();
?>


<p><a href="http://localhost/index.php"><button>back to previous page</button></a></p>