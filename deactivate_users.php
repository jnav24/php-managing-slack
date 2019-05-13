<?php

require_once __DIR__ . '/bootstrap.php';

$usersObj = new Src\Controllers\Users;
$users = $usersObj->getAllUsers([ 'limit' => 5 ]);

$markedForDeletion = array_filter($users, function($user) use ($usersObj) {
    return $usersObj->isUserAMember($user) && !$usersObj->isBillingActive($user);
});

var_dump($markedForDeletion);

if (!empty($markedForDeletion)) {
//    $usersObj->setUserAsDeactivated($markedForDeletion[0]);
}