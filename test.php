<?php
require_once(__DIR__ . '/bootstrap.php');

use JoliCode\Slack\Api\Model\ObjsUser;
use JoliCode\Slack\ClientFactory;

$client = ClientFactory::create(getenv('OAUTH_ACCESS_TOKEN'));
/** @var ObjsUser $users */
$results = [];
$try = 4;

if ($try === 1) {
    $response = $client->usersInfo([
        'user' => 'U20L49VS6',
    ]);
    var_dump($response->getUser()->getDeleted());
    var_dump($response->getUser()->getIsRestricted());
    var_dump($response->getUser()->getIsUltraRestricted());
}

if ($try === 2) {
    $response = $client->usersList([
        'limit' => 5,
    ]);
    var_dump($response->count());
    var_dump($response->getMembers());
}

if ($try === 3) {
    $response = $client->usersGetPresence([
        'user' => 'U02V0JZ4K',
    ]);
}

if ($try === 4) {
    $id = 'U02V0JZ4K';
    $response = $client->teamBillableInfo([
        'user' => $id,
    ]);
    $obj = json_decode(json_encode($response));
    var_dump($obj->billable_info->{$id}->billing_active);
}
