<?php
/**
 * @author Serzh Yevtushenko <s.evtyshenko@gmail.com>
 * Date: 9/8/16
 */

namespace AppBundle\Services\SocialProvider;


use AppBundle\Entity\SocialAccount;

interface CalendarInterface
{

    public function getCalendarEvents(SocialAccount $account);

    public function addCalendarEvent(SocialAccount $account, $eventText);
    
    
}