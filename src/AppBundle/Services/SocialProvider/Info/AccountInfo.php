<?php
/**
 * @author Serzh Yevtushenko <s.evtyshenko@gmail.com>
 * Date: 9/8/16
 */

namespace AppBundle\Services\SocialProvider\Info;


class AccountInfo
{

    protected $id;

    protected $accessToken;

    protected $name;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return AccountInfo
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     * @return AccountInfo
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}