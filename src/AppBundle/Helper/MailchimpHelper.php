<?php

namespace AppBundle\Helper;

use DrewM\MailChimp\MailChimp;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Класс для подписки пользователя к сервису mailchimp
 *
 *
 */
class MailchimpHelper extends AbstractHelper
{
    /**
     * Метод подписки пользователя к сервису mailchimp
     *
     * @param string $email
     *
     * @return string сообщение об ошибке или успешной подписке
     */
    public function subscribeEmail(string $email): string
    {
        $result = '';
        
        $errors = $this->container->get('validator')->validate(
            $email, 
            [
                new Email(),
                new NotBlank()
            ]
        );

        if (count($errors) > 0) {
            foreach ($errors as $i) {
                $result = $i->getMessage();
            }
        } else {
            $mailChimp = new MailChimp($this->container->getParameter('mailchimp_api_key'));
            $listId = $this->container->getParameter('mailchimp_list_id');
            $subscriberHash = $mailChimp->subscriberHash($email);
            $apiResult = $mailChimp->get('lists/' . $listId . '/members/' . $subscriberHash);
            
            if (isset($apiResult['status']) && $apiResult['status'] === 'subscribed') {
                $result = 'Email is already a list member';
                $this->container->get('monolog.logger.subscribe')->info('Mailchimp info - Email is already a list member', ['email' => $email]);
            } else {
                $mailChimp->post('lists/' . $listId . '/members', [
                    'email_address' => $email,
                    'status'        => 'subscribed',
                ]);

                if (!$mailChimp->success()) {
                    $result = 'Subscribe error';
                    $this->container->get('monolog.logger.subscribe')->error('Mailchimp error - '.$mailChimp->getLastError(), ['email' => $email]);
                } else {
                    $result = 'Email is subscribed';
                }
            }
        }

        return $result;
    }
}
