<?php

require_once('dbconnector.php');

class Form extends dbConnector
{
    public $results_per_page;
    public $sort_by;

    public function __construct(
        $servername,
        $dbusername,
        $dbpassword,
        $dbname,
        $dbsubname,
        $results_per_page,
        $sort_by

    ) {
        parent::__construct($servername, $dbusername, $dbpassword, $dbname, $dbsubname);

        $this->servername = $servername;
        $this->dbusername = $dbusername;
        $this->dbpassword = $dbpassword;
        $this->dbname = $dbname;
        $this->dbsubname = $dbsubname;
        $this->results_per_page = $results_per_page;
        $this->sort_by = $sort_by;
    }
    public function AddForm()
    {
        echo '  <form action="action.php" method="post" id="captcha_form">
                    <p>User Name <input type="text" name="name" /></p>
                    <p>E-mail <input type="text" name="mail" /></p>
                    <p>Homepage <input type="text" name="Homepage" /></p>
                    <p>Text <input type="text" name="Text" /></p> 
                    <p><input type="submit" value="Submit"></p>
                </form>';
    }
    public function AddFormWithCaptcha()
    {
        echo '  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                <form action="action.php" method="post" id="captcha_form">
                    <p>User Name <input type="text" name="name" /></p>
                    <p>E-mail <input type="text" name="mail" /></p>
                    <p>Homepage <input type="text" name="Homepage" /></p>
                    <p>Text <input type="text" name="Text" /></p>
                    <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                    <br />
                    <p><input type="submit" value="Submit"></p>
                </form>';
    }
    public function AddSortingButtons()
    {
        echo '<form method="post">
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
            ';
    } 
    public function LoadResultsFromdb()
    {

        if (isset($_POST['Name'])) {
            $this->sort_by = "Name";
        }
        if (isset($_POST['mail'])) {
            $this->sort_by = "mail";
        }
        if (isset($_POST['Homepage'])) {
            $this->sort_by = "Homepage";
        }
        if (isset($_POST['Text'])) {
            $this->sort_by = "Text";
        }
        if (isset($_POST['date'])) {
            $this->sort_by = "date";
        }

        if (isset($_GET["page"])) {
            $this->page  = $_GET["page"];
        } else {
            $this->page = 1;
        };
        $start_from = ($this->page - 1) * $this->results_per_page;
        $sql =  "SELECT * FROM $this->dbsubname ORDER BY $this->sort_by ASC LIMIT $start_from, " . $this->results_per_page;
        $rs_result = $this->conn->query($sql);

        while ($row = $rs_result->fetch_assoc()) {
            echo   " - cridentials: " . $row["Name"] . " " . $row["mail"] . " " . $row["Homepage"] . " " . $row["Text"] . " " . $row["date"] . "<br>";
        }
    }
    public function AddLoadPagesButtons()
    {
        $sql = "SELECT COUNT(name) AS total FROM $this->dbsubname";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $total_pages = ceil($row["total"] / $this->results_per_page); // calculate total pages with results

        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
            echo "<a href='index.php?page=" . $i . "'";
            if ($i == $this->page)  echo " class='curPage'";
            echo ">" . $i . "</a> ";
        };
    }
}

?>