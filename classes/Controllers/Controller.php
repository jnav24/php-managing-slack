<?php

namespace Src\Controllers;

use JoliCode\Slack\ClientFactory;
use Src\Factories\ClientFactory as ClientLegacyFactory;
use Src\Traits\Log;

class Controller
{
    use Log;

    protected $client;
    protected $clientLegacy;

    public function __construct()
    {
        $this->client = ClientFactory::create(getenv('SLACK_ACCESS_TOKEN'));
        $this->clientLegacy = ClientLegacyFactory::create(getenv('SLACK_LEGACY_TOKEN'));
        $this->logSetup();
    }
}