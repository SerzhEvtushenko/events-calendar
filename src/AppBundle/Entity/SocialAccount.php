<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SocialAccount
 *
 * @ORM\Table(name="social_account")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SocialAccountRepository")
 */
class SocialAccount
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $socialId;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $providerType;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $accessToken = [];

    /**
     * @var User
     *
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="accounts")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $user;

    /**
     * @var Event[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event", mappedBy="account")
     */
    private $events;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $eventsUpdatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * Set providerType
     *
     * @param string $providerType
     *
     * @return SocialAccount
     */
    public function setProviderType($providerType)
    {
        $this->providerType = $providerType;

        return $this;
    }

    /**
     * Get providerType
     *
     * @return string
     */
    public function getProviderType()
    {
        return $this->providerType;
    }

    /**
     * Set accessToken
     *
     * @param array $accessToken
     *
     * @return SocialAccount
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken
     *
     * @return array
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return SocialAccount
     */
    public function addEvent(\AppBundle\Entity\Event $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Event $event
     */
    public function removeEvent(\AppBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return SocialAccount
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set socialId
     *
     * @param string $socialId
     *
     * @return SocialAccount
     */
    public function setSocialId($socialId)
    {
        $this->socialId = $socialId;

        return $this;
    }

    /**
     * Get socialId
     *
     * @return string
     */
    public function getSocialId()
    {
        return $this->socialId;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return SocialAccount
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set eventsUpdatedAt
     *
     * @param \DateTime $eventsUpdatedAt
     *
     * @return SocialAccount
     */
    public function setEventsUpdatedAt($eventsUpdatedAt)
    {
        $this->eventsUpdatedAt = $eventsUpdatedAt;

        return $this;
    }

    /**
     * Get eventsUpdatedAt
     *
     * @return \DateTime
     */
    public function getEventsUpdatedAt()
    {
        return $this->eventsUpdatedAt;
    }

    public function __toString()
    {
        return $this->name;
    }
}
