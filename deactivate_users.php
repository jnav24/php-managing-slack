<?php

require_once __DIR__ . '/bootstrap.php';

use JoliCode\Slack\Api\Model\ObjsUser;

$usersObj = new Src\Controllers\Users;
$options = [ 'limit' => 20 ];
$users = $usersObj->getAllUsers($options);
$whitelist = [];

$i = 0;
while($users) {
    array_map(function(ObjsUser $user) use ($usersObj, $whitelist) {
        $email = $usersObj->getUserEmail($user);

        if (!$user->getDeleted() && $usersObj->isUserAMember($user) && !$usersObj->isBillingActive($user) && !in_array($email, $whitelist) && !$user->getIsBot()) {
            $usersObj->setUserAsDeactivated($user);
        } else {
            $usersObj->info('User is skipped', [ 'user' => $user->getRealName(), 'email' => $email ]);
        }
    }, $users);

    $options['cursor'] = $usersObj->getNextCursor();
    $users = $usersObj->getAllUsers($options);

    sleep(60);
    $i++;

    if ($i === 900) {
        $users = [];
    }
}