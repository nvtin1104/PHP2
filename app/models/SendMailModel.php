<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require __DIR_ROOT__ . '/public/lib/vendor/autoload.php';
class SendMailModel
{
    function sendMail($usermail, $username, $title, $body)
    {
        $status = false;
        $mail = new PHPMailer(true);
        $mail->Debugoutput = 'error_log';
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->setLanguage('vi', __DIR_ROOT__ . '/public/lib/vendor/phpmailer/phpmailer/language/phpmailer.lang-vi.php');
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = filter_var($_ENV['SMTP_AUTH'], FILTER_VALIDATE_BOOLEAN);
            $mail->Username = $_ENV['SMTP_USERNAME'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];
            $mail->Port = $_ENV['SMTP_PORT'];

            //Recipients
            $mail->setFrom($_ENV['SMTP_USERNAME'], 'BookShop BMT');
            $mail->addAddress($usermail, $username);
            $mail->addReplyTo($_ENV['SMTP_USERNAME'], 'BookShop BMT');
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $title;
            $mail->Body    = $body;
            $mail->AltBody = 'Vui lòng liên hệ camtinlqd123@gmail.com';

            $mail->send();
            $status = true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        return $status;
    }
}
