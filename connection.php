
<?php

class Connection
{
    private $servername;
    private $dbusername;
    private $dbpassword;
    private $dbname;
    private $dbsubname;


    public function __construct(
        $servername,
        $dbusername,
        $dbpassword,
        $dbname,
        $dbsubname

    ) {
        $this->servername = $servername;
        $this->dbusername = $dbusername;
        $this->dbpassword = $dbpassword;
        $this->dbname = $dbname;
        $this->dbsubname = $dbsubname;
        $this->conn = null;
        $this->isCaptchaSucced = true;
    }
    public function Checkcaptcha()
    {
        if (empty($_POST['g-recaptcha-response'])) {
            echo 'Captcha is required';
            $this->isCaptchaSucced = false;
        } else {

            $secret_key = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';

            $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

            $response_data = json_decode($response);

            if (!$response_data->success) {
                echo 'Captcha verification failed';
                $this->isCaptchaSucced = false;
            } else {
                $this->isCaptchaSucced = true;
            }
        }
    }
    public function Connect()
    {
        $conn = mysqli_connect($this->servername, $this->dbusername, $this->dbpassword, $this->dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            $this->conn = $conn;
        }
    }
    public function CloseConection()
    {
        mysqli_close($this->conn);
    }
    public function InsertIntodb($name, $mail, $Homepage, $Text)
    {
        if (!$this->isCaptchaSucced == true) {
            echo 'captcha not succed';
        } else {
            if (!(preg_match('/[a-z]{1,12}/i', $name) and
                preg_match('/^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})*$/i', $mail) and
                preg_match('/((http|https):\/\/)(www.)?[a-zA-Z0-9@:%._\\+~#?&\/\/=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%._\\+~#?&\/\/=]*)/i', $Homepage) and
                preg_match('/[a-z]{1,300}/i', $Text))) {

                echo "you provided bad credentials";
            } else {

                $sql = "INSERT INTO `$this->dbsubname`(`Name`, `mail`, `Homepage`, `Text`) VALUES ('$name','$mail','$Homepage','$Text')";

                if (!mysqli_query($this->conn, $sql)) {

                    echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
                } else {

                    echo "</p>" . "New record created successfully" . "</p>";

                    echo '  <p>Здравствуйте, ' . $name . '</p>' .
                        '<p>ваш email, ' . $mail . '</p>' .
                        '<p>ваш сайт, ' . $Homepage . '</p>' .
                        '<p>ваше сообщение миру, ' . $Text . '</p>';
                }
            }
        }
    }
}
?>