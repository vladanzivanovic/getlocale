<?php

namespace App\Components;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Templating\EngineInterface;

class Email
{
    protected $lem;
    protected $mailer;
    protected $templateEngine;
    private $codeGenerator;
    private $parameterBag;

    /**
     * Email constructor.
     *
     * @param EntityManagerInterface $loggerEm
     * @param \Swift_Mailer          $mailer
     * @param EngineInterface        $templateEngine
     * @param ParameterBagInterface  $parameterBag
     */
    public function __construct(
        EntityManagerInterface $loggerEm,
        \Swift_Mailer $mailer,
        EngineInterface $templateEngine,
        ParameterBagInterface $parameterBag
    )
    {
        $this->lem = $loggerEm;
        $this->mailer = $mailer;
        $this->templateEngine = $templateEngine;
        $this->parameterBag = $parameterBag;
    }

    /**
     * Prepare data and send email
     * @param array $data
     * @return string
     * @throws \Twig_Error
     * @throws \Swift_SwiftException
     * @throws \RuntimeException
     */
    public function setAndSendEmail(array $data)
    {
        $body = $this->templateEngine->render(
            "email/" . $data['template'] . ".html.twig", $data
        );
        $attachments = (isset($data['attachments'])) ? $data['attachments'] : null;
        $subject = isset($data['subject']) ? $data['subject'] : 'Go Locale';

        return $this->send($data, $body, $subject, $attachments);
    }

    /**
     * Send email
     *
     * @param $data
     * @param $body
     * @param null $subject
     * @param array $attachments
     * @return string
     * @throws \Swift_SwiftException
     */
    private function send($data, $body, $subject = null, array $attachments = null)
    {
        try {
            $emailInstance = (new \Swift_Message())
                ->setSubject($subject)
                ->setFrom($data['from'][0], $data['from'][1])
                ->setTo($data['to'][0], $data['to'][1])
                ->setBody($body, 'text/html')
                ->addPart(strip_tags($body));

            if (isset($data['reply'])) {
                $emailInstance->setReplyTo($data['reply'][0], $data['reply'][1]);
            }

            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $emailInstance->attach(( new \Swift_Attachment())->setFile($attachment));
                }
            }

            $this->mailer->send($emailInstance);
//            $data['status'] = Emails::EMAIL_SUCCESS;
//            $this->saveEmail($data);
        } catch (\Swift_TransportException $swift_TransportException){
            $data['status'] = Emails::EMAIL_FAILED;
            $data['errorMessage'] = $swift_TransportException->getMessage();
            $this->saveEmail($data);
            throw new \Swift_SwiftException(MessageConstants::EMAIL_NOT_SENT);
        }
        return true;
    }

    private function saveEmail(array $data)
    {
        if(!empty($data)){
            $email = new Emails();

            $email->setFromemail(isset($data['replyTo']) ? $data['replyTo'] : $data['fromEmail']);
            $email->setToemail($data['toEmail']);
            $email->setRawdata(json_encode($data));
            $email->setStatus($data['status']);
            $email->setErrormessage(isset($data['errorMessage']) ? $data['errorMessage'] : null);
            $email->setScript($data['script']);
            $email->setSyscreatedutc(new \DateTime());
            $email->setCode($data['templateData']['code']);

            $this->lem->persist($email);
            $this->lem->flush($email);
            $this->lem->clear();
        }
    }
}