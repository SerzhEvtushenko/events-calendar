<?php
/**
 * @author Serzh Yevtushenko <s.evtyshenko@gmail.com>
 * Date: 9/8/16
 */

namespace AppBundle\Services;


use AppBundle\Entity\SocialAccount;
use AppBundle\Entity\User;
use AppBundle\Services\SocialProvider\Info\AccountInfo;
use AppBundle\Services\SocialProvider\SocialProviderFactory;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class UserHelper
{
    /** @var SocialProviderFactory */
    private $providerFactory;

    /** @var EntityManager */
    private $em;

    /** @var TokenStorage */
    private $securityTokenStorage;


    /**
     * UserHelper constructor.
     *
     * @param SocialProviderFactory $providerFactory
     * @param EntityManager         $entityManager
     * @param TokenStorage          $tokenStorage
     */
    public function __construct(SocialProviderFactory $providerFactory, EntityManager $entityManager, TokenStorage $tokenStorage)
    {
        $this->providerFactory      = $providerFactory;
        $this->em                   = $entityManager;
        $this->securityTokenStorage = $tokenStorage;
    }

    /**
     * @return \AppBundle\Entity\SocialAccount[]|array
     */
    public function getAccountList()
    {
        $user     = $this->getCurrentUser();
        $accounts = $this->em->getRepository('AppBundle:SocialAccount')->findByUserWithEvents($user);

        return $accounts;
    }


    /**
     * @param $type
     * @param $code
     *
     * @return bool
     * @throws \Exception
     */
    public function addSocialAccount($type, $code)
    {
        $result   = false;
        $user     = $this->getCurrentUser();
        $provider = $this->providerFactory->getProvider($type);
        $info     = $provider->getAccountInfo($code);

        if ($info && !$this->socialUserExists($info->getId())) {
            $this->addNewSocialUser($info, $user, $type);

            $result = true;
        }

        $this->em->flush();

        return $result;
    }

    /**
     * @param AccountInfo $info
     * @param User        $user
     * @param string      $providerType
     *
     * @return SocialAccount
     */
    private function addNewSocialUser(AccountInfo $info, User $user, $providerType)
    {
        $socialUser = new SocialAccount();
        $socialUser->setUser($user);
        $socialUser->setSocialId($info->getId());
        $socialUser->setProviderType($providerType);
        $socialUser->setName($info->getName());
        $socialUser->setAccessToken($info->getAccessToken());

        $this->em->persist($socialUser);

        return $socialUser;
    }

    /**
     * @param $socialId
     *
     * @return bool
     */
    private function socialUserExists($socialId)
    {
        $socialUser = $this->em->getRepository('AppBundle:SocialAccount')->findOneBy(['socialId' => $socialId]);

        return !!$socialUser;
    }

    public function getCurrentUser()
    {
        $token = $this->securityTokenStorage->getToken();

        if ($token) {
            $user = $token->getUser();

            if (is_object($user)) {
                return $user;
            }
        }

        throw  new \Exception('User not logged');
    }

}