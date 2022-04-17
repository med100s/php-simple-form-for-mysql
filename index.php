<?php

require_once('./form.php');


$servername = "localhost";
$dbusername = "admin";
$dbpassword = "admin";
$dbname = "test";
$dbsubname = "myguests2";


$list = new Form($servername, $dbusername, $dbpassword, $dbname, $dbsubname, 10, 'Name');
// $list->AddForm();
$list->AddFormWithCaptcha();
$list->Connect();
$list->LoadResultsFromdb();
$list->AddLoadPagesButtons();
$list->AddSortingButtons();
$list->CloseConection(); 
?>