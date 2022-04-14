<script src="https://www.google.com/recaptcha/api.js" async defer></script>



<form action="action.php" method="post" id="captcha_form">
    <p>User Name <input type="text" name="name" /></p>
    <p>E-mail <input type="text" name="mail" /></p>
    <p>Homepage <input type="text" name="Homepage" /></p>
    <p>Text <input type="text" name="Text" /></p>
    <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
    <br />
    <p><input type="submit" value="Submit"></p>
</form>


<form method="post">
    <button name="name"> sort by name</button>
</form>

<form method="post">
    <button name="mail"> sort by mail</button>
</form> 

<form method="post">
    <button name="Homepage"> sort by Homepage</button>
</form>

<form method="post">
    <button name="Text"> sort by Text</button>
</form> 

<form method="post">
    <button name="date"> sort by date</button>
</form> 


<?php
$servername = "localhost";
$dbusername = "admin";
$dbpassword = "admin";
$dbname = "test";
$dbsubname = "myguests2";

$results_per_page = 25;

$sort_by = 'Name';

if (isset($_POST['Name'])) {
    $sort_by = "Name";
}
if (isset($_POST['mail'])) {
    $sort_by = "mail";
}
if (isset($_POST['Homepage'])) {
    $sort_by = "Homepage";
}
if (isset($_POST['Text'])) {
    $sort_by = "Text";
}
if (isset($_POST['date'])) {
    $sort_by = "date";
}

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $results_per_page;
$sql =  "SELECT * FROM $dbsubname ORDER BY $sort_by ASC LIMIT $start_from, " . $results_per_page;
$rs_result = $conn->query($sql);

while ($row = $rs_result->fetch_assoc()) {
    echo   " - cridentials: " . $row["Name"] . " " . $row["mail"] . " " . $row["Homepage"] . " " . $row["Text"] . " " . $row["date"] . "<br>";
}


?>



<?php
$sql = "SELECT COUNT(name) AS total FROM $dbsubname";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results

for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
    echo "<a href='index.php?page=" . $i . "'";
    if ($i == $page)  echo " class='curPage'";
    echo ">" . $i . "</a> ";
};
?>