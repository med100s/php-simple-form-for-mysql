<?php

require_once('./classes/form.php');


$servername = "localhost";
$dbusername = "admin";
$dbpassword = "admin";
$dbname = "test";
$dbsubname = "myguests2";


$Form = new Form($servername, $dbusername, $dbpassword, $dbname, $dbsubname, 10, 'Name');
// $Form->AddForm();
$Form->AddFormWithCaptcha();
$Form->Connect();
$Form->LoadResultsFromdb();
$Form->AddLoadPagesButtons();
$Form->AddSortingButtons();
$Form->CloseConection(); 
?>