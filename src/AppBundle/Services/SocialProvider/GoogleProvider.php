<?php
/**
 * @author Serzh Yevtushenko <s.evtyshenko@gmail.com>
 * Date: 9/8/16
 */

namespace AppBundle\Services\SocialProvider;


use AppBundle\Entity\SocialAccount;
use AppBundle\Services\SocialProvider\Info\AccountInfo;

class GoogleProvider extends AbstractSocialProvider implements CalendarInterface
{

    protected $scopes = [
        \Google_Service_Plus::PLUS_ME,
        \Google_Service_Calendar::CALENDAR_READONLY
    ];

    protected $clientId;
    protected $clientSecret;
    protected $appName;

    /**
     * GoogleProvider constructor.
     *
     * @param $clientId     string
     * @param $clientSecret string
     * @param $appName      string
     */
    public function __construct($clientId, $clientSecret, $appName)
    {
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
        $this->appName      = $appName;
    }


    public function generateCreateAccountUrl()
    {
        $client = $this->createClientInstance();

//        $client->setClassConfig('Google_Auth_OAuth2', 'prompt', 'consent');

        return $client->createAuthUrl();
    }

    private function createClientInstance()
    {
        $client = new \Google_Client();
        $client->setApplicationName($this->appName);
        $client->setScopes($this->scopes);
        $client->setClientId($this->clientId);
        $client->setClientSecret($this->clientSecret);
        $client->setAccessType('offline');

        $route = $this->getCallbackUrl('social_create_account_callback');

        $client->setRedirectUri($route);

        return $client;
    }

    public function getType()
    {
        return SocialProviderFactory::TYPE_GOOGLE;
    }

    /**
     * @param $authCode string
     *
     * @return AccountInfo
     */
    public function getAccountInfo($authCode)
    {
        try {
            $client      = $this->createClientInstance();
            $accessToken = $client->authenticate($authCode);
            $googleAuth  = new \Google_Service_Plus($client);
            $profile     = $googleAuth->people->get('me');

            if (!$profile) {
                return null;
            }

            $info = new AccountInfo();
            $info
                ->setId($profile->getId())
                ->setAccessToken($accessToken)
                ->setName($profile->getDisplayName());

            return $info;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param SocialAccount $account
     *
     * @return \Google_Service_Calendar_Events
     */
    public function getCalendarEvents(SocialAccount $account)
    {
        $accessToken = $account->getAccessToken();
        $client      = $this->createClientInstance();
        $client->setAccessToken($accessToken);

        $events  = [];
        $service = new \Google_Service_Calendar($client);

        $calendarId = 'primary';
        $optParams  = [
            'maxResults'   => self::CHUNK_LENGTH,
            'orderBy'      => 'startTime',
            'singleEvents' => true,
            'timeMin'      => date('c'),
        ];

        try {
            $result = $service->events->listEvents($calendarId, $optParams);
            while (true) {
                $events = array_merge_recursive($events, $result->getItems());

                if (count($events) >= 500) {
                    break;
                }

                $pageToken = $result->getNextPageToken();
                if ($pageToken) {
                    $optParams['pageToken'] = $pageToken;
                    $result                 = $service->events->listEvents('primary', $optParams);
                } else {
                    break;
                }
            }
        } catch (\Exception $e) {
            //todo Log exception
        }

        return $events;
    }

    /**
     * @param SocialAccount $account
     * @param               $eventText
     *
     * @return \Exception|\Google_Service_Calendar_Event
     */
    public function addCalendarEvent(SocialAccount $account, $eventText)
    {
        $accessToken = $account->getAccessToken();
        $client      = $this->createClientInstance();
        $client->setAccessToken($accessToken);

        $service = new \Google_Service_Calendar($client);

        try {
            $createdEvent = $service->events->quickAdd('primary', $eventText);

            return $createdEvent;
        } catch (\Exception $e) {
            //todo Log exception
        }

        return null;
    }
}