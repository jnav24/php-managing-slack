<?php
require_once(__DIR__ . '/bootstrap.php');

use JoliCode\Slack\Api\Model\ObjsUser;
use JoliCode\Slack\ClientFactory;

$client = ClientFactory::create(getenv('SLACK_ACCESS_TOKEN'));
/** @var ObjsUser $users */
$results = [];
$page = 1;

do {
    // This method require your token to have the scope "users:read"
    echo('Retrieve page ' . $page . "\n");
    try {
        $response = $client->teamAccessLogs([
            'page' => strval($page++),
        ]);

        if($response->getOk()) {
            $temp = $response->getArrayCopy();
            exit(print_r($temp['logins'], true));
            $results = array_merge($results, $temp['logins']);
        } else {
            echo 'Could not retrieve the list.', PHP_EOL;
        }
    }
    catch(Exception $ex) {
        if($ex->getMessage() === 'Too Many Requests') {
            sleep(60);
        }

        $page--;
        echo($ex->getMessage() . "\n");
    }
} while($page <= 100);

if(!empty($results)) {
    $string_data = serialize($results);
    file_put_contents("data.txt", $string_data);
}