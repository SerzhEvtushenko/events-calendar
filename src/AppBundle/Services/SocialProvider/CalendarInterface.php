<?php
/**
 * @author Serzh Yevtushenko <s.evtyshenko@gmail.com>
 * Date: 9/8/16
 */

namespace AppBundle\Services\SocialProvider;


use AppBundle\Entity\SocialAccount;

interface CalendarInterface
{

    const CHUNK_LENGTH = 100;
    
    public function getCalendarEvents(SocialAccount $account);

    public function addCalendarEvent(SocialAccount $account, $eventText);
    
    
}