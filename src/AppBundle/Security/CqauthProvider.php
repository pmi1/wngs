<?php
namespace AppBundle\Security;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Entity\User;
use AppBundle\Entity\RoleGroup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Security;
use Application\Sonata\MediaBundle\Entity\Media;

class CqauthProvider extends OAuthUserProvider
{
    protected $session, $doctrine, $admins, $em;

    public function __construct($session, $doctrine, $serviceContainer)
    {
        $this->session = $session;
        $this->doctrine = $doctrine;
        $this->container = $serviceContainer;
        $this->em = $this->doctrine->getRepository(User::class);
    }

    public function loadUserByUsername($id)
    {
        return $this->em->findOneBy(['id' => $id]);
    }

    /***
     * @param UserResponseInterface $response
     * @return OAuthUser|\HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser|\Symfony\Component\Security\Core\User\UserInterface
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $source = $response->getResourceOwner()->getName();
        $user = $this->em->findOneBy(['oauthType' => $source, 'oauthId' => $response->getUserName()]);

        if (! $user) {
            $user = $this->em->findOneBy(['login' => $response->getEmail()]);
        }

        if (! $user) {
            $user = new User();
            $user->setName($response->getRealName());
            $user->setLogin($response->getEmail());
            $user->setOauthType($source);
            $user->setOauthId($response->getUserName());
            $user->setStatus(1);
            $mediaManager = $this->container->get('sonata.media.manager.media');
            $media = new Media();
            $temp = tempnam(sys_get_temp_dir(), 'TMP_');
            file_put_contents($temp, file_get_contents($response->getProfilePicture()));
            $media_sizes = getimagesize($temp);
            $media->setWidth($media_sizes[0]);
            $media->setHeight($media_sizes[1]);
            $media->setBinaryContent($temp);
            $media->setContext('media_context_user_image');
            $media->setProviderName('sonata.media.provider.image');
            $mediaManager->save($media);
            $user->setImage($media);
            $roleGroupEntity = $this->doctrine->getRepository(RoleGroup::class);
            $roleGroupArray = $roleGroupEntity->findOneBy(['id' => 4]);
            $user->addRoleGroup($roleGroupArray);

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->container->get('security.token_storage')->setToken($token);
            $this->container->get('session')->set('_security_main', serialize($token));
        }

        return $this->em->findOneBy(['id' => $user->getId()]);
    }
}