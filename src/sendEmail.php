<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class sendEmail
{
    public $subject;
    public $message;
    private $mail;

    public function __construct($subject, $message)
    {
        $credentials = require_once(WP_PLUGIN_DIR . "/fixer-api-fx-converter/src/credentials.php");
        $this->subject = $subject;
        $this->message = $message;
        $this->mail = new PHPMailer(true);

        // $this->mail->SMTPDebug  = SMTP::DEBUG_SERVER;
        $this->mail->Host       = $credentials["smtp-domain"];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $credentials["smtp-user"];
        $this->mail->Password   = $credentials["smtp-password"];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port       = 465;
    }

    public function send()
    {
        $this->mail->setFrom("info@web-html.com", 'Access Bureau Mailing');
        $this->mail->addAddress("sebasgomez5892@gmail.com", "Sebastian Gomez");
        $this->mail->isHTML(true);
        $this->mail->Subject = $this->subject;
        $this->mail->Body    = $this->message;
        $this->mail->send();
    }
}
