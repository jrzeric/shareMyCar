<?php
require_once 'email.php';

$to = 'eric.jrz@gmail.com';
$subject = 'Test';
$body = 'This is a test';

$email = new Email($to, $subject, $body);
if($email->send()) {
    // some code here if ok
    echo "Ok";
} else {
    // some code if error
    echo ":c";
}

?>
