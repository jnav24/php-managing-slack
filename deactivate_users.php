<?php

require_once __DIR__ . '/bootstrap.php';

use JoliCode\Slack\Api\Model\ObjsUser;

$usersObj = new Src\Controllers\Users;
$users = $usersObj->getAllUsers([ 'limit' => 6 ]);
$whitelist = [];

array_map(function(ObjsUser $user) use ($usersObj, $whitelist) {
    $email = $usersObj->getUserEmail($user);

    if (!$user->getDeleted() && $usersObj->isUserAMember($user) && !$usersObj->isBillingActive($user) && !in_array($email, $whitelist)) {
        $usersObj->setUserAsDeactivated($user);
    }
}, $users);