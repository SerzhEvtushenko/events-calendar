<?php
/**
 * @author Serzh Yevtushenko <s.evtyshenko@gmail.com>
 * Date: 9/8/16
 */

namespace AppBundle\Services;


use AppBundle\Entity\Event;
use AppBundle\Entity\SocialAccount;
use AppBundle\Services\SocialProvider\SocialProviderFactory;
use Doctrine\ORM\EntityManager;

class CalendarHelper
{
    const EVENT_COUNTER = 50;

    /** @var SocialProviderFactory */
    private $providerFactory;
    /** @var EntityManager */
    private $em;


    /**
     * CalendarHelper constructor.
     *
     * @param SocialProviderFactory $providerFactory
     * @param EntityManager         $entityManager
     */
    public function __construct(SocialProviderFactory $providerFactory, EntityManager $entityManager)
    {
        $this->providerFactory = $providerFactory;
        $this->em              = $entityManager;
    }

    /**
     * @param SocialAccount $socialAccount
     *
     * @throws \Exception
     */
    public function updateEventsFromCalendar(SocialAccount $socialAccount)
    {
        $provider = $this->providerFactory->getProvider($socialAccount->getProviderType());
        $events   = $provider->getCalendarEvents($socialAccount);

        if ($events) {
            //todo change logic for update list 
            $this->dropAccountEvents($socialAccount);

            $counter = 0;
            foreach ($events as $event) {
                $this->addEvent($socialAccount, $event);

                $counter++;
                if ($counter >= self::EVENT_COUNTER) {
                    try {
                        $this->em->flush();
                        $this->em->clear();
                    } catch (\Exception $e) {
                        //todo Log exception
                    }
                }
            }
        }

        $socialAccount->setEventsUpdatedAt(new \DateTime());
    }

    /**
     * @param SocialAccount $socialAccount
     * @param               $eventText
     *
     * @return array
     * @throws \Exception
     */
    public function addNewEvent(SocialAccount $socialAccount, $eventText)
    {
        $provider = $this->providerFactory->getProvider($socialAccount->getProviderType());
        $event    = $provider->addCalendarEvent($socialAccount, $eventText);

        if ($event instanceof \Google_Service_Calendar_Event) {
            $this->addEvent($socialAccount, $event);
            $this->em->flush();

            return true;
        }

        return false;
    }

    /**
     * @param SocialAccount $socialAccount
     */
    private function dropAccountEvents(SocialAccount $socialAccount)
    {
        $this->em->getRepository('AppBundle:Event')->deleteByAccount($socialAccount);
    }

    /**
     * @param SocialAccount                  $socialAccount
     * @param \Google_Service_Calendar_Event $event
     */
    private function addEvent(SocialAccount $socialAccount, \Google_Service_Calendar_Event $event)
    {
        $eventObject = new Event();
        $eventObject->setAccount($socialAccount);
        $eventObject->setSummary($event->getSummary());
        $eventObject->setSocialId($event->getId());
        $eventObject->setCreator($event->getCreator());
        $eventObject->setStartAt($event->getStart());
        $eventObject->setEndAt($event->getEnd());
        $eventObject->setStatus($event->getStatus());

        $this->em->persist($eventObject);
    }

}