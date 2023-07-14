<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Controller\Backend\ListCommonController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

/**
 * Админ-контроллер для коллекций
 */
class SelectionController extends ListCommonController
{

    public function deleteAction($id)
    {

        $object  = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        if ($id == $this->container->getParameter('promo_id')
            || $id == $this->container->getParameter('sale_id')
            || $id == $this->container->getParameter('flash_sale_id')
            || $id == $this->container->getParameter('sale_predictor_id')) {

            $this->addFlash(
                'sonata_flash_error',
                'You cannot delete this record.'
            );

            return $this->redirectTo($object);
        }

        return parent::deleteAction($id);
    }

    public function batchActionDelete(ProxyQueryInterface $query)
    {
        $is = $query->execute();

        foreach ($is as $row) {

            if ($row->getId() === $this->container->getParameter('promo_id')
                || $row->getId() === $this->container->getParameter('sale_id')
                || $row->getId() === $this->container->getParameter('flash_sale_id')
                || $row->getId() === $this->container->getParameter('sale_predictor_id')) {

                $this->addFlash(
                    'sonata_flash_error',
                    'You cannot delete this record.'
                );

                return new RedirectResponse(
                    $this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters()))
                );
            }
        }

        return parent::batchActionDelete($query);
    }
}
