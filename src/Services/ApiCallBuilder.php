<?php
namespace Services;


use GuzzleHttp\Client;

/**
 * @author bslezak <brian@theslezaks.com>
 *
 */
class ApiCallBuilder
{
   
    /**
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param string $authMethod none|digest|basic
     * @return \APICall
     */
    public static function CreateApiCall($hostname, $authMethod = 'none', $username = '', $password = '')
    {
        $client = new Client(
            ['base_uri' => "http://$hostname:8087",
                'headers' => [
                    'Accept'     => 'application/json',
                    'Content-Type' => 'application/json; charset=utf-8',
        
                ],
        
            ]
            );
        
        $clientAuth = new \ApiAuth($username, $password, $authMethod);
        
        return new \ApiCall($client, $clientAuth);
    }
}

