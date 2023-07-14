<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Clinic;
use AppBundle\Entity\FormAnswer;
use AppBundle\Type\FormAnswerType;
use Application\Sonata\MediaBundle\Entity\Media;
use Symfony\Component\Form\Form;

/**
 * Класс сервис для форм
 *
 * @author Ignatov Pavel aka AtlantiS <ignatov-pavel@adlabs.ru>
 */
class FormManager extends AbstractManager
{
    /**
     * saveCallbackForm - Сохраняет форму заказа обратного звонка и генерирует ответ
     *
     * @param FormAnswer $formAnswer ответ для формы
     * @param string $clinicIdsFromForm список идентификаторов клиник, разделенный запятой
     * @param string|null $httpReferer страница с которой отправлена форма
     * @param int|null $formType идентификатор типа формы
     *
     * @return FormAnswer
     */
    public function saveCallbackForm(FormAnswer $formAnswer, string $clinicIdsFromForm, string $httpReferer = null, $formType)
    {
        $em = $this->container->get('doctrine')->getManager();
        $clinicRepo = $this->getRepository(Clinic::class);

        $formAnswer->setFormType($formType);
        $formAnswer->setAnsweredAt(new \DateTime('now'));
        $formAnswer->setRefererLink($httpReferer);
        $clinicIdsFromFormArray = explode(',', $clinicIdsFromForm);
        
        for ($i = 0; $i < count($clinicIdsFromFormArray); $i++) {
            $clinicIdsFromFormArray[$i] = (int)$clinicIdsFromFormArray[$i];
        }
        
        if ($clinicIdsFromForm) {
            $select = $clinicRepo->getSelectClinicsByIds($clinicIdsFromForm);
                
            foreach ($select->getResult() as $clinic) {
                $clinic->setAnsweredAt(new \DateTime('now'));
                $em->persist($clinic);
                $em->flush();
                
                $formAnswer->addClinic($clinic);
            }
        }
        
        $em->persist($formAnswer);
        $em->flush();
        
        $templateData = [
            'formAnswer' => $formAnswer,
            'FormAnswerType' => FormAnswerType::getChoices()
        ];
        
        $this->container->get('app.swiftmailer_notify_helper')->sendAdminMailAnswerForm($templateData);
        
        return $formAnswer;
    }
    
    /**
     * saveRequestForm - Сохраняет форму заявки
     *
     * @param FormAnswer  $formAnswer ответ для формы
     * @param string $clinicIdsFromForm список идентификаторов клиник, разделенный запятой
     * @param string|null $httpReferer страница с которой отправлена форма
     * @param array $formFiles массив файлов из формы
     * @param int|null $formType идентификатор типа формы
     *
     * @return FormAnswer
     */
    public function saveRequestForm(FormAnswer $formAnswer, string $httpReferer = null, array $formFiles, $formType)
    {
        $em = $this->container->get('doctrine')->getManager();
        
        $formAnswer->setFormType($formType);
        $formAnswer->setAnsweredAt(new \DateTime('now'));
        $formAnswer->setRefererLink($httpReferer);
        $em->persist($formAnswer);
        $em->flush();
        
        $templateData = [
            'formAnswer' => $formAnswer,
            'FormAnswerType' => FormAnswerType::getChoices()
        ];
        
        //$this->container->get('app.swiftmailer_notify_helper')->sendUserMailAnswerForm($formAnswer->getName(), $formAnswer->getEmail());
        //$this->container->get('app.swiftmailer_notify_helper')->sendAdminMailAnswerForm($templateData);

        return $formAnswer;
    }
}
