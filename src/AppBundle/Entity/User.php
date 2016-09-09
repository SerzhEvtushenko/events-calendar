<?php

/**
 * @author Serzh Yevtushenko <s.evtyshenko@gmail.com>
 * Date: 9/8/16
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Youshido\SecurityUserBundle\Entity\SecuredUser;

/**
 * @ORM\Entity
 */
class User extends SecuredUser
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var SocialAccount[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SocialAccount", mappedBy="user")
     */
    private $accounts;


    /**
     * Add account
     *
     * @param \AppBundle\Entity\SocialAccount $account
     *
     * @return User
     */
    public function addAccount(\AppBundle\Entity\SocialAccount $account)
    {
        $this->accounts[] = $account;

        return $this;
    }

    /**
     * Remove account
     *
     * @param \AppBundle\Entity\SocialAccount $account
     */
    public function removeAccount(\AppBundle\Entity\SocialAccount $account)
    {
        $this->accounts->removeElement($account);
    }

    /**
     * Get accounts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccounts()
    {
        return $this->accounts;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accounts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get enable
     *
     * @return boolean
     */
    public function getEnable()
    {
        return $this->enable;
    }
}
