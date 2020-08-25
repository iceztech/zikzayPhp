<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 8/8/2020
 *Time: 3:40 PM
 */

namespace Zikzay\libs\mail;


use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Email extends PHPMailer
{
    private static $attachments;

    public function __construct()
    {
        parent::__construct(true);
        $this->settings();
    }

    private function settings()
    {
        date_default_timezone_set('Etc/UTC');
        $this->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $this->isSMTP();
        $this->Host = 'smtp.gmail.com';
        $this->SMTPAuth = true;
        $this->Username = 'zikzay@gmail.com';
        $this->Password = 'Chimaeze@1';
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //PHPMailer::ENCRYPTION_STARTTLS;
        $this->Port = 465; // 587
        $this->AuthType = 'XOAUTH2';
        $this->isHTML(true);

        try {
            $this->setFrom('zikzay@gmail.com', 'Isaac Eze');
        } catch (Exception $e) {

        }
    }

    private function prepare($to, $subject, $message, $cc = null, $bcc = null)
    {
        $this->Subject = $subject;
        $this->Body = $message;
        $this->AltBody = $message;
        try {
            $this->sendTo($to);
            if($cc) $this->addCC($cc);
            if($bcc) $this->addBCC($bcc);
            return parent::send();
        } catch (Exception $e) {
            return false;
        }
    }

    public static function message($to, $subject, $message, $cc = null, $bcc = null)
    {
        $self = new self;
        $self->getAttachment(self::$attachments);
        return $self->prepare($to, $subject, $message, $cc, $bcc);
    }

    public static function attachments($file, $fileName = null)
    {
        self::$attachments[] = ['file' => $file, 'fileName' => $fileName];
    }

    /**
     * @param $to
     * @throws Exception
     */
    private function sendTo($to)
    {

        if(is_array($to)){
            foreach ($to as $name => $email) {
                $this->addAddress($email, $name);
                $this->addReplyTo($email, $name);
            }
        }else {
            $this->addAddress($to);
            $this->addReplyTo($to);
        }
    }

    private function getAttachment($attachments) {
        if(isset($attachments[0])) {
            foreach ($attachments as $attachment) {
                try {
                    $this->addAttachment($attachment['file'], $attachment['fileName']);
                } catch (Exception $e) {
                }
            }
        }
    }
}


