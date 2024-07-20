<?php

namespace Libraries;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
final class Mailer
{
    private function __construct() { }
    public final static function sendEmail(string $fromEmail, string $fromName, string $toEmail, string $toName, string $subject, string $body) : bool {
        return self::sendEmailUsingMailer($fromEmail, $fromName, $toEmail, $toName, $subject, $body);
    }

    private static function sendEmailUsingMailer(string $fromEmail, string $fromName, string $toEmail, string $toName, string $subject, string $body) : bool {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = MAIL_PORT;

            //Recipients
            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($toEmail, $toName);
            $mail->addReplyTo(MAIL_REPLAY_TO_EMAIL, MAIL_REPLAY_TO_NAME);
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');

            //Content
            // $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}