<?php

declare(strict_types=1);

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Src\Models;

class Client extends \Jane\OpenApiRuntime\Client\Psr7HttplugClient
{
    public static function create($httpClient = null)
    {
        if (null === $httpClient) {
            $httpClient = \Http\Discovery\HttpClientDiscovery::find();
            $plugins = [];
            $uri = \Http\Discovery\UriFactoryDiscovery::find()->createUri('https://slack.com/api');
            $plugins[] = new \Http\Client\Common\Plugin\AddPathPlugin($uri);
            $plugins[] = new \Http\Client\Common\Plugin\AddHostPlugin($uri);
            $httpClient = new \Http\Client\Common\PluginClient($httpClient, $plugins);
        }
        $messageFactory = \Http\Discovery\MessageFactoryDiscovery::find();
        $streamFactory = \Http\Discovery\StreamFactoryDiscovery::find();
        $serializer = new \Symfony\Component\Serializer\Serializer(\JoliCode\Slack\Api\Normalizer\NormalizerFactory::create(), [
            new \Symfony\Component\Serializer\Encoder\JsonEncoder(new \Symfony\Component\Serializer\Encoder\JsonEncode(),
            new \Symfony\Component\Serializer\Encoder\JsonDecode())
        ]);

        return new static($httpClient, $messageFactory, $serializer, $streamFactory);
    }

    /**
     * Sets the user as inactive; deactivates user account
     *
     * @param array $queryParameters {
     *
     *     @var string $token Authentication token. Requires scope: `users:read`
     *     @var string $user User to get info on
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \JoliCode\Slack\Api\Model\UsersInfoGetResponse200|\JoliCode\Slack\Api\Model\UsersInfoGetResponsedefault|\Psr\Http\Message\ResponseInterface|null
     */
    public function usersAdminInactive(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executePsr7Endpoint(new \Src\Endpoints\UsersAdminInactive($queryParameters), $fetch);
    }
}