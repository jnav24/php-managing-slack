<?php

require_once __DIR__ . '/../bootstrap.php';

use JoliCode\Slack\ClientFactory;
use JoliCode\Slack\Api\Model\ObjsUser;

class Users
{
    private $client;

    public function __construct()
    {
        $this->client = ClientFactory::create(getenv('SLACK_ACCESS_TOKEN'));
    }

    /**
     * @param array $params {
     *      limit integer
     *      include_locale bool
     * }
     * @return array|\JoliCode\Slack\Api\Model\ObjsUser[]|null
     */
    public function getAllUsers(array $params = [])
    {
        return array_filter($this->client->usersList($params)->getMembers(), function(ObjsUser $user) {
            return $user->getName() !== 'slackbot';
        });
    }

    /**
     * Checks if user is not in the following:
     *      restricted - multi-channel guest
     *      unrestricted - single channel guest
     *
     * @param ObjsUser $user
     * @return bool
     */
    public function isUserAMember(ObjsUser $user)
    {
        return !$user->getIsUltraRestricted() && !$user->getIsRestricted();
    }

    /**
     * Gets the billing active status for a user
     *
     * @param ObjsUser $user
     * @return bool
     */
    public function isBillingActive(ObjsUser $user)
    {
        $id = $user->getId();
        $response = $this->client->teamBillableInfo([
            'user' => $id
        ]);

        if ($response->getOk()) {
            $obj = json_decode(json_encode($response));
            return $obj->billable_info->{$id}->billing_active;
        }

        return false;
    }

    public function setUserAsDeactivated()
    {}
}