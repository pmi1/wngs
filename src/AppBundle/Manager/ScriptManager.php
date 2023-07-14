<?php

namespace AppBundle\Manager;

use AppBundle\Entity\CmfScript;

/**
 * Класс сервис для текстовых страниц
 *
 *
 */
class ScriptManager extends AbstractManager
{
    /**
     * getScriptByUrl - извлекает из базы простую текстовую страницу по полю realcatname или id
     *
     * @param string $slug урл текстовой страницы
     *
     * @return CmfScript|null
     */
    public function getScriptByUrl(string $slug)
    {
        $slug = trim($slug, "/");
        
        $scriptRepo = $this->getRepository(CmfScript::class);

        return $scriptRepo->getScriptByUrl($slug);
    }

    /**
     * generateUrl - сгенерировать url страницы объекта cmfScript с учетом среды
     *
     * @param CmfScript $object
     *
     * @return string
     */
    public function generateUrl(CmfScript $object): string
    {
        $url = null;
        
        $router = $this->container->get('router');
        $baseUrl = $router->getContext()->getBaseUrl();

        $repo = $this->getRepository(CmfScript::class);
        
        $isClientSection = $repo->isClientSection($object);

        if (!$object->getIsGroupNode() && $isClientSection) {
            if (trim($object->getUrl()) != '') {
                $url = trim($object->getUrl());
                
                if (mb_strlen($url) > 0 && $url[0] === '/') {
                    $url = $baseUrl . $url ;
                }
            } else {
                $url = $router->generate('docpage', array('slug' => $object->getRealcatname()));
            }
        } else {
            $url = '';
        }
        
        return $url;
    }
}
