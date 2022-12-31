<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\SMTP;

class Wf_mail
{
    public function __construct()
    {
    }

    public function __get($var)
    {
        return get_instance()->controller->$var;
    }

    public function send_mail($to, $subject, $body, $from = null, $from_name = null, $attachment = null, $cc = null, $bcc = null)
    {

        if ($this->mSettings->protocol == 'mailchimp') {
            try {
                $mailchimp = new MailchimpTransactional\ApiClient();
                $mailchimp->setApiKey($this->mSettings->mailchimp_api_key);


                $response = $mailchimp->messages->send(["message" => [
                    "from_email" => $from ? $from : $this->mSettings->invoice_mail,
                    "subject" => $subject,
                    "text" => $body,
                    "to" => [
                        [
                            "email" => $to,
                            "type" => "to"
                        ]
                    ]
                ]]);
                if($response[0]->status == 'sent'){
                    return true;
                }
                return false;
            } catch (Error $e) {
                return false;
            }
        }

        $mail          = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        try {
            if ($this->mSettings->protocol == 'mail') {
                $mail->isMail();
            } elseif ($this->mSettings->protocol == 'sendmail') {
                $mail->isSendmail();
            } elseif ($this->mSettings->protocol == 'smtp') {
                $mail->isSMTP();
                $mail->Host       = $this->mSettings->smtp_host;
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = !empty($this->mSettings->smtp_crypto) ? $this->mSettings->smtp_crypto : false;
                $mail->Port       = $this->mSettings->smtp_port;
                $mail->Username = $this->mSettings->smtp_user;
                $mail->Password = $this->mSettings->smtp_pass;
            } else {
                $mail->isMail();
            }

            if ($from && $from_name) {
                $mail->setFrom($from, $from_name);
                $mail->addReplyTo($from, $from_name);
            } elseif ($from) {
                $mail->setFrom($from, $this->mSettings->invoice_name);
                $mail->addReplyTo($from, $this->mSettings->invoice_name);
            } else {
                $mail->setFrom($this->mSettings->invoice_mail, $this->mSettings->invoice_name);
                $mail->addReplyTo($this->mSettings->invoice_mail, $this->mSettings->invoice_name);
            }

            $mail->addAddress($to);
            if ($cc) {
                try {
                    if (is_array($cc)) {
                        foreach ($cc as $cc_email) {
                            $mail->addCC($cc_email);
                        }
                    } else {
                        $mail->addCC($cc);
                    }
                } catch (\Exception $e) {
                    log_message('info', 'PHPMailer Error: ' . $e->getMessage());
                }
            }
            if ($bcc) {
                try {
                    if (is_array($bcc)) {
                        foreach ($bcc as $bcc_email) {
                            $mail->addBCC($bcc_email);
                        }
                    } else {
                        $mail->addBCC($bcc);
                    }
                } catch (\Exception $e) {
                    log_message('info', 'PHPMailer Error: ' . $e->getMessage());
                }
            }
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($mail->Body);
            if ($attachment) {
                if (is_array($attachment)) {
                    foreach ($attachment as $attach) {
                        $mail->addAttachment($attach);
                    }
                } else {
                    $mail->addAttachment($attachment);
                }
            }

            if (!$mail->send()) {
                log_message('error', 'Mail Error: ' . $mail->ErrorInfo);
                throw new Exception($mail->ErrorInfo);
            }
            return true;
        } catch (MailException $e) {
            log_message('error', 'Mail Error: ' . $e->getMessage());
            throw new \Exception($e->errorMessage());
        } catch (\Exception $e) {
            log_message('error', 'Mail Error: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
