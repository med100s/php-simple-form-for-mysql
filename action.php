<?php

require_once('./connection.php');

$servername = "localhost";
$dbusername = "admin";
$dbpassword = "admin";
$dbname = "test";
$dbsubname = "myguests2";

$name = $_POST['name'];
$mail = $_POST['mail'];
$Homepage = $_POST['Homepage'];
$Text = $_POST['Text'];


$list = new Connection($servername, $dbusername, $dbpassword, $dbname, $dbsubname);
$list->Checkcaptcha();
$list->Connect();
$list->InsertIntodb($name, $mail, $Homepage, $Text);
$list->CloseConection();
?>


<p><a href="http://localhost/index.php"><button>back to previous page</button></a></p>