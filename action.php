<p>Здравствуйте, <?php echo htmlspecialchars($_POST['name']); ?>.</p>
<p>ваш email, <?php echo htmlspecialchars($_POST['mail']); ?>.</p>
<p>ваш сайт, <?php echo htmlspecialchars($_POST['Homepage']); ?>.</p>
<p>ваше сообщение миру, <?php echo htmlspecialchars($_POST['Text']); ?>.</p>

<?php
$servername = "localhost";
$dbusername = "admin";
$dbpassword = "admin";
$dbname = "test";
$dbsubname = "myguests2";

$name = $_POST['name'];
$mail = $_POST['mail'];
$Homepage = $_POST['Homepage'];
$Text = $_POST['Text'];


if (empty($_POST['g-recaptcha-response'])) {
    echo 'Captcha is required';
} else {

    $secret_key = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';

    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

    $response_data = json_decode($response);

    if (!$response_data->success) { 

        echo 'Captcha verification failed';

    } else {

        echo "</p>" . "captcha succeed" . "</p>";

        if (
            preg_match('/[a-z]{1,12}/i', $name) AND 
            preg_match('/^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})*$/i', $mail) AND 
            preg_match('/((http|https):\/\/)(www.)?[a-zA-Z0-9@:%._\\+~#?&\/\/=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%._\\+~#?&\/\/=]*)/i', $Homepage) AND 
            preg_match('/[a-z]{1,300}/i', $Text)
        ) {
            
            $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "INSERT INTO `$dbsubname`(`Name`, `mail`, `Homepage`, `Text`) VALUES ('$name','$mail','$Homepage','$Text')";

            if (mysqli_query($conn, $sql)) {
                echo "</p>" . "New record created successfully" . "</p>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        } else {
            echo "you provided bad credentials";
        }
    }
}

?>


<p><a href="http://localhost/index.php"><button>back to previous page</button></a></p>
