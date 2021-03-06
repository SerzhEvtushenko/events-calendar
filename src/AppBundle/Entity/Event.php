<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\EventRepository")
 */
class Event
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
     * @ORM\Column(type="string")
     */
    private $socialId;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $startAt;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $endAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $creator;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $summary;

    /**
     * @var SocialAccount
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SocialAccount", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $account;

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
     * Set account
     *
     * @param \AppBundle\Entity\SocialAccount $account
     *
     * @return Event
     */
    public function setAccount(\AppBundle\Entity\SocialAccount $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \AppBundle\Entity\SocialAccount
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set socialId
     *
     * @param string $socialId
     *
     * @return Event
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Event
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set creator
     *
     * @param array $creator
     *
     * @return Event
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return array
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Event
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return Event
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set startAt
     *
     * @param array $startAt
     *
     * @return Event
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return array
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param array $endAt
     *
     * @return Event
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return array
     */
    public function getEndAt()
    {
        return $this->endAt;
    }
}
