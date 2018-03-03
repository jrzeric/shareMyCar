<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

const FROM = '0315108790@miutt.edu.mx';
const HOST = 'smtp.office365.com';
const USERNAME = '0315108790@miutt.edu.mx';
const PASSWORD = 'x@Smc_2018!';
const PORT = '587';

class Email
{
    //Recipients infomration variables and constants
    protected $to;
    protected $FROM = FROM;
    protected $subject;
    protected $body;
    //Server settings constants
    protected $HOST = HOST;
    protected $USERNAME = USERNAME;
    protected $PASSWORD = PASSWORD;
    protected $PORT = PORT;

    function __construct()
    {
        if (func_num_args() == 0) {
            $this->to = '';
            $this->subject = '';
            $this->body = '';
        }
        if (func_num_args() == 3) {
            $arguments = func_get_args();
            $this->to = $arguments[0];
            $this->subject = $arguments[1];
            $this->body = $arguments[2];
        }
    }

    /**
     * Sends the Email.
     *
     * @return bool True if email was sent, false if not.
     */
    public function send()
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $this->HOST;
            $mail->SMTPAuth = true;
            $mail->Username = $this->USERNAME;
            $mail->Password = $this->PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = $this->PORT;

            //Recipients
            $mail->setFrom($this->FROM, 'ShareMyCar Team');
            $mail->addAddress($this->to);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            // $message = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
            return false;
        }
    }
}
