<?php

require_once ('PHPMailerAutoload.php');
require_once ('class.phpmailer.php');
require_once ('../database/connection.php');

class mailConnection {

    private $mail;
    private $con;

    public function __construct() {
        $this->mail = new PHPMailer();
        $this->con = new connection();


//$body             = file_get_contents('contents.html');
//$body             = eregi_replace("[\]",'',$body);

        $this->mail->IsSMTP(); // telling the class to use SMTP
        $this->mail->isHTML(TRUE);
        $this->mail->Host = "kobi6255@gmail.com"; // SMTP server
        $this->mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        $this->mail->SMTPAuth = true;                  // enable SMTP authentication

        $this->mail->Host = "smtp.gmail.com"; // sets the SMTP server
        $this->mail->Port = 587;                    // set the SMTP port for the GMAIL server
        $this->mail->Username = "kobi6255@gmail.com"; // SMTP account username
        $this->mail->Password = "kobi2300";        // SMTP account password

        $this->mail->SetFrom('kobi6255@gmail.com', 'קובי דהן');

        $this->mail->CharSet = 'UTF-8';

        $this->mail->SMTPKeepAlive = true;
        $this->mail->AltBody = ""; // optional, comment out and test
    }

    /**
     * this function sends the trainees' email the user name and password according to the id of each of the trainees.
     * @param $user
     * @param $email
     * @param $id
     */
    public function sendMessage($user, $email, $id) {
        $password = $this->con->GeneratePassword();
        $this->mail->Subject = "קבלת סיסמא חדשה";
        $this->mail->addEmbeddedImage("../images/logo.png", "logo");
        $this->mail->Body = "<img src=\"cid:logo\" />";
        $this->mail->Body .= "לקוח יקר שלום,<br>אנו מודים לך על הרשמת לסטודיו gsn.<br>"
                . "שם המשתמש שלך הוא:" . "$user<br>" . "וסיסמתך היא:<br>" . "$password";
        $this->mail->AddAddress($email);
        if (!$this->mail->Send()) {
            echo "Mailer Error: " . die($this->mail->ErrorInfo);
        } else {
            $this->con->insertPasswordAndUserName($user, $password, $id);
        }
        $this->mail->ClearAddresses();
    }

    /**
     * this function sends a message to all the trainees about the lesson at which they were registered.
     * @param $idlesson
     * @param $message
     */
    public function SendMultiMail($idlesson, $message) {
        $this->mail->Subject = "התראה מהסטודיו";
        $this->mail->addEmbeddedImage("../images/logo.png", "logo");
        $this->mail->Body = "<img src=\"cid:logo\" /><br>";
        $this->mail->Body .= $message;
        $result = $this->con->GetCustomersByLessonid($idlesson);
        while ($row = mysqli_fetch_array($result)) {
            $this->mail->addAddress($row['mail']);
            $this->mail->send();
            $this->mail->ClearAddresses();
        }
        $this->mail->clearAttachments();
    }

    /**
     * this function sends a message to all the trainees about the lesson at which they were registered.
     * @param $email
     * @param $message
     * @return mail.
     */
    public function SendSpecialMessage($email, $message) {
        $this->mail->ClearAddresses();
        $this->mail->Subject = "הודעה מיוחדת";
        $this->mail->addEmbeddedImage("../images/logo.png", "logo");
        $this->mail->Body = "<img src=\"cid:logo\" />";
        $this->mail->Body .= $message;
        $this->mail->AddAddress($email);
        return $this->mail->Send();
    }

}
