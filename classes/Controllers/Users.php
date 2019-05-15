<?php

namespace Src\Controllers;

use JoliCode\Slack\Api\Model\ObjsUser;

class Users extends Controller
{
    private $responseMetaData;

    /**
     * @param array $params {
     *      limit integer
     *      include_locale bool
     * }
     * @return array|\JoliCode\Slack\Api\Model\ObjsUser[]|null
     */
    public function getAllUsers(array $params = [])
    {
        $response = $this->client->usersList($params);

        if (!$response->getOk()) {
            return [];
        }

        $this->responseMetaData = $response->getResponseMetadata();
        return array_filter($response->getMembers(), function(ObjsUser $user) {
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

    /**
     * Set the user account as deactivated
     *
     * @param ObjsUser $user
     */
    public function setUserAsDeactivated(ObjsUser $user)
    {
        $this->debug('User to be deleted', [ 'user' => $user->getRealName(), 'email' => $this->getUserEmail($user) ]);
        $response = $this->clientLegacy->usersAdminInactive([
            'user' => $user->getId(),
        ]);

        if (!$response->getOk()) {
            $this->error('Error updating user', [ 'user' => $user ]);
        }
    }

    public function getUserEmail(ObjsUser $user)
    {
        $reflection = new \ReflectionClass($user->getProfile());
        $property = $reflection->getProperty('email');
        $property->setAccessible(true);
        return $property->getValue($user->getProfile());
    }

    public function getResponseMetaData()
    {
        return $this->responseMetaData;
    }

    public function getNextCursor()
    {
        $reflection = new \ReflectionClass($this->getResponseMetaData());
        $property = $reflection->getProperty('nextCursor');
        $property->setAccessible(true);
        return $property->getValue($this->getResponseMetaData());
    }
}