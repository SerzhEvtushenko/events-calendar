<?php
/**
 * @author Serzh Yevtushenko <s.evtyshenko@gmail.com>
 * Date: 9/8/16
 */

namespace AppBundle\Services\SocialProvider;


class SocialProviderFactory
{
    const TYPE_GOOGLE = 'GOOGLE';

    private $providers = [
        self::TYPE_GOOGLE,
    ];

    /**
     * SocialProviderFactory constructor.
     *
     * @param GoogleProvider $googleProvider
     */
    public function __construct(GoogleProvider $googleProvider)
    {
        $this->providers[ self::TYPE_GOOGLE ] = $googleProvider;
    }

    /**
     * @param $key
     *
     * @return AbstractSocialProvider
     * @throws \Exception
     */
    public function getProvider($key)
    {
        if (!in_array($key, array_keys($this->providers))) {
            throw new \Exception('Wrong key');
        }

        $provider = $this->providers[ $key ];

        if (!$provider) {
            throw new \Exception('Invalid provider');
        }

        return $provider;
    }
}