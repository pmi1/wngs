<?php

namespace AppBundle\Helper;

use AppBundle\Entity\MaillistTemplate;

/**
 * Класс для отправки уведомлений через swiftmailer
 *
 */
class SwiftMailerNotifyHelper extends AbstractHelper
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    
    /**
     * @var string
     */
    private $adminMail;

    /**
     * @var string
     */
    private $senderMail;

    /**
     * SwiftMailerNotifyHelper constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param string $adminMail
     * @param string $senderMail
     *
     * @return void
     */
    public function __construct(\Swift_Mailer $mailer, string $adminMail, string $senderMail)
    {
        $this->mailer = $mailer;
        $this->adminMail = $adminMail;
        $this->senderMail = $senderMail;
    }

    /**
     * sendMail - Отправляет письмо по номеру шаблона
     *
     * @param int $id ид почтового шаблона
     * @param array $templateData переменные для почтового шаблона
     *
     * @return void
     */
    public function sendMail($id, $templateData)
    {
        $translator = $this->container->get('translator');

        $mailRepo = $this->getRepository(MaillistTemplate::class);
        $template = $mailRepo->findOneBy(array(
            'id' => $id
        ));

        if (!$template) {
            throw $this->createNotFoundException(
                'No mail template was found for this id: ' . $id
            );
        }

        $defaults = array(
            'from' => $template->getFromEmail() ? $template->getFromEmail() : $this->senderMail,
            'fromName' => $template->getFromName(),
            'to' => $template->getToEmail() ? $template->getToEmail() : $this->adminMail,
            'toName' => $template->getToName(),
            'subject' => $template->getSubject() ? $template->getSubject() : $translator->trans('mail_notify_success'),
        );

        $result = array_merge($defaults, $templateData);
        //$result['to'] = 'adlabs.sp@gmail.com';

        $twig = $this->container->get('twig');
        $body = $template->getText()->getRaw();

        $message = (new \Swift_Message())
            ->setSubject($result['subject'])
            ->setFrom($result['from'])
            ->setTo($result['to']);

        preg_match_all( '@src="([^"]+)"@' , $body, $match );

        foreach ($match[1] as $k => $v) {
            if (file_exists($f= $this->container->get('kernel')->getRootDir().'/../web'.$v)) {
                $templateData['image'.$k] = $message->embed(\Swift_Image::fromPath($f));
                $body = str_replace($match[0][$k], 'src="{{image'.$k.'}}"', $body);
            }
        }

        preg_match_all( '@url\(\'([^\']+)\'\)@' , $body, $match );

        foreach ($match[1] as $k => $v) {

            if (file_exists($f= $this->container->get('kernel')->getRootDir().'/../web'.$v)) {
                $templateData['image_'.$k] = $message->embed(\Swift_Image::fromPath($f));
                $body = str_replace($match[0][$k], 'url(\'{{image_'.$k.'}}\')', $body);
            }
       }

        $template = $twig->createTemplate($body);

        $message->setBody(
                $template->render($templateData),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
