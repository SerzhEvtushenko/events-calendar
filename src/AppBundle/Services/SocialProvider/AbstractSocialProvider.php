<?php
/**
 * @author Serzh Yevtushenko <s.evtyshenko@gmail.com>
 * Date: 9/8/16
 */

namespace AppBundle\Services\SocialProvider;


use AppBundle\Services\SocialProvider\Info\AccountInfo;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractSocialProvider implements ContainerAwareInterface, CalendarInterface
{
    use ContainerAwareTrait;

    abstract public function generateCreateAccountUrl();

    abstract public function getType();

    /**
     * @param $authCode string
     *
     * @return AccountInfo
     */
    abstract public function getAccountInfo($authCode);

    protected function getCallbackUrl($route)
    {
        $router = $this->container->get('router');
        $url    = $router->generate($route, ['type' => $this->getType()], UrlGeneratorInterface::ABSOLUTE_URL);

        return $url;
    }

}