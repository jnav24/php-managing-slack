<?php

require_once __DIR__ . '/classes/Users.php';

$usersObj = new Users;
$users = $usersObj->getAllUsers([ 'limit' => 5 ]);

$markedForDeletion = array_filter($users, function($user) use ($usersObj) {
    return $usersObj->isUserAMember($user) && !$usersObj->isBillingActive($user);
});

var_dump($markedForDeletion);