<?php

/*
 * This file is part of JoliCode's Slack PHP API project.
 *
 * (c) JoliCode <coucou@jolicode.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Src\Factories;

use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\AddPathPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\Plugin\HeaderAppendPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Src\Models\Client;

class ClientFactory
{
    public static function create(string $token, HttpClient $httpClient = null): Client
    {
        // Find a default HTTP client if none provided
        if (null === $httpClient) {
            $httpClient = HttpClientDiscovery::find();
        }

        // Decorates the HTTP client with some plugins
        $uri = UriFactoryDiscovery::find()->createUri('https://slack.com/api');
        $pluginClient = new PluginClient($httpClient, [
            new ErrorPlugin(),
            new AddPathPlugin($uri),
            new AddHostPlugin($uri),
            new HeaderAppendPlugin([
                'Authorization' => 'Bearer '.$token,
            ]),
        ]);

        // Instantiate an OpenApi client generated by Jane
        return Client::create($pluginClient);
    }
}