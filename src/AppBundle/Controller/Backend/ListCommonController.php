<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\CmfConfigure;
use AppBundle\Form\ConfigureType;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Дефолтный админ-контроллер для списковых сущностей
 */
class ListCommonController extends Controller
{
    /**
     * configureAction - акшен реализующий возможность задания списка отображаемых полей в списке сущности.
     *
     * @return Response
     */
    public function configureAction()
    {
        $request = $this->getRequest();
        $this->admin->checkAccess('list');
        $userId = 1;
        $script = $this->admin->getClassnameLabel();
        $configure = $this->getDoctrine()->getRepository(CmfConfigure::class);
        $fields = $configure->getConfigureFields($userId, $script);
        $data = array();
        $is = array();
        
        foreach ($fields as $i) {
            $is[$i['fieldName']] = $i['fieldName'];
            
            if (true === $i['isVisuality']) {
                $data[] = $i['fieldName'];
            }
        }
        
        $form = $this->createForm(ConfigureType::class, null, array('data' => $data, 'choices' => $is));
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            foreach ($fields as &$i) {
                $i['isVisuality'] = in_array($i['fieldName'], $data['fields']) ? 1 : 0;
            }
            
            unset($i);
            $configure->setConfigureFields($userId, $script, $fields);

            return new RedirectResponse($this->admin->generateUrl('list'));
        }

        return $this->render('admin/configure.html.twig', array(
            'form' => $form->createView(),
            'action' => 'configure',
        ));
    }

    /**
     * @param $id
     */
    public function cloneAction($id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        $clonedObject = clone $object;

        $clonedObject->setId(null);
        $clonedObject->setName($object->getName().' (Clone)');

        $this->admin->create($clonedObject);

        $this->addFlash('sonata_flash_success', 'Cloned successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }
}
