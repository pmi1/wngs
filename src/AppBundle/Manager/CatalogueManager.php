<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Catalogue;

/**
 * Класс сервис для текстовых страниц
 *
 *
 */
class CatalogueManager extends AbstractManager
{
    /**
     * getCatalogueByUrl - извлекает из базы простую текстовую страницу по полю realcatname или id
     *
     * @param string $slug урл текстовой страницы
     *
     * @return Catalogue|null
     */
    public function getScriptByUrl(string $slug)
    {
        $slug = trim($slug, "/");
        
        $catalogueRepo = $this->getRepository(Catalogue::class);

        return $catalogueRepo->getCatalogueByUrl($slug);
    }

    /**
     * generateUrl - сгенерировать url страницы объекта Catalogue с учетом среды
     *
     * @param Catalogue $object
     *
     * @return string
     */
    public function generateUrl(Catalogue $object): string
    {
        $url = '';
        
        $router = $this->container->get('router');
        //$url = $router->generate('cat', array('slug' => $object->getRealcatname()));

        return $url;
    }
}
