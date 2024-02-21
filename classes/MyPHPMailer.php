<?php

namespace classes;
require __DIR__ . '/../packages/phpmailer/src/PHPMailer.php';
require __DIR__ .'/../packages/phpmailer/src/SMTP.php';
require __DIR__ .'/../packages/phpmailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class MyPHPMailer extends PHPMailer
{
    public function __construct()
    {      
        parent::__construct(true);
        $this->setFrom('busregistration@hermankoch.co.za', 'Bus Registration');
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->Port = 465;
        $this->SMTPAuth = true;
        $this->isSMTP();
        $this->Host = 'test.mailserver.co.za';
        $this->Port = 465;
        $this->SMTPAuth = true;
        $this->Username = 'busregistration@mailserver.co.za';
        $this->Password = 'T!3sT@123';
        $this->setFrom('busregistration@mailserver.co.za', 'Bus Registration');
        $this->addReplyTo('busregistration@mailserver.co.za', 'Bus Registration');
        $this->WordWrap = 80;
    }
    public function sendEmail(string $to, string $subject, string $body): bool
    {
        // Format HTML email template
        $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><meta http-equiv="X-UA-Compatible" content="IE=edge"></head><body>';
        $body = $html . $body . '</body></html>';
        $this->addAddress($to);
        $this->Subject = $subject;
        $this->msgHTML($body);
        if (!$this->send()) {
            return false;
        }
        return true;
    }
}