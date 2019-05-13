<?php

namespace Src\Controllers;

use JoliCode\Slack\ClientFactory;
use Src\Factories\ClientFactory as ClientLegacyFactory;

class Controller
{
    protected $client;
    protected $clientLegacy;

    public function __construct()
    {
        $this->client = ClientFactory::create(getenv('SLACK_ACCESS_TOKEN'));
        $this->clientLegacy = ClientLegacyFactory::create(getenv('SLACK_LEGACY_TOKEN'));
    }
}