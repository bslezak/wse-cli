<?php
namespace WseCliBundle\DependencyInjection;

use GuzzleHttp\Client;
use WseCliBundle\Model\ApiAuth;
use WseCliBundle\Model\ApiCall;
use WseCliBundle\WseCliBundle;

/**
 *
 * ApiCallBuilder
 *
 * A factory for building ApiCall model objects
 *
 * @author Brian Slezak <brian@theslezaks.com>
 * @version @application_version@
 *
 */
class ApiCallBuilder
{

    /**
     *
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param string $authMethod
     *            none|digest|basic
     * @return ApiCall
     */
    public static function CreateApiCall($hostname, $authMethod = 'none', $username = '', $password = '')
    {
        $client = new Client([
            'base_uri' => "http://$hostname:8087",
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json; charset=utf-8'

            ]

        ]);

        $clientAuth = new ApiAuth($username, $password, $authMethod);

        return new ApiCall($client, $clientAuth);
    }
}

