<?php

namespace App\Utils;

use SendGrid\Mail\From;
use SendGrid\Mail\HtmlContent;
use SendGrid\Mail\Mail;
use SendGrid\Mail\PlainTextContent;
use SendGrid\Mail\Subject;
use SendGrid\Mail\To;
use SendGrid\Mail\Personalization;

use SendGrid;
use Log;

class Email
{   
    private $sender = [];
    private $recipients = [];
    private $mailer;
    private $lastErrorMessage = null;
    private $toCount = 0;

    public function __construct() {
        $options['curl'] = [
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ];
        
        $this->mailer = new SendGrid(env('SENDGRID_API_KEY'), $options);
        $this->setSender(env('MAIL_FROM_NAME'), env('MAIL_FROM_EMAIL'));
    }

    public function setSender($name, $email) {
        $this->sender = new From($email, $name);
        return $this;
    }

    public function addRecipient(string $name, string $email, array $substitutions = [], string $subject = null) {
        $this->recipients[] = new To($email, $name, $substitutions, $subject);
        return $this;
    }

    public function getRecipients() {
        return $this->recipients;
    }

    private function prepareForSending() {
        if(empty($this->sender) || empty($this->recipients))
            throw new \Exception("Sender and Recipients must not be empty", 1);
        return new Mail($this->sender, $this->recipients);
    }

    private function dispatch(Mail $email) {
        try {
            $response = $this->mailer->send($email);
            // range in 2XX
            if(!(200 <= $response->statusCode() && $response->statusCode() <= 299)){
                $this->lastErrorMessage = $response->body();
            }
                
        } catch (Exception $e) {
            $this->lastErrorMessage = $e->getMessage();
            Log::channel(config('logging.default'))
            ->error('SMS sending failed: '.$this->lastErrorMessage);
        }
    }

    public function sendUsingTemplate(
        string $templateId
    ) {
        $email = $this->prepareForSending();
        $email->setTemplateId($templateId);
        return $this->dispatch($email);
    }

    public function send(
        string $subject, 
        string $body,
        array $substitutions = []
    ) {
        $email = $this->prepareForSending();
        $email->setSubject($subject);
        $email->addContent("text/html", $body);
        return $this->dispatch($email);
    }

    public function getLastErrorMessage() {
        return $this->lastErrorMessage;
    }
}