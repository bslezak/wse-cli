<?php

namespace WseCliBundle\Model;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

/**
 * ApiCall.
 *
 * @author Brian Slezak <brian@theslezaks.com>
 */
class ApiCall
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var APIAuth
     */
    protected $clientAuth;

    /**
     * @var string
     */
    protected $methodType;

    /**
     * @var mixed
     */
    protected $postData;

    /**
     * @return the $postData
     */
    public function getPostData()
    {
        return [
            'body' => $this->postData,
        ];
    }

    /**
     * @param mixed $postData
     */
    public function setPostData($postData)
    {
        $this->postData = $postData;
    }

    public function __construct(Client $client, ApiAuth $clientAuth)
    {
        $this->client = $client;
        $this->clientAuth = $clientAuth;
    }

    public function GetUri()
    {
        return $this->uri;
    }

    public function SetUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return the $methodType
     */
    public function getMethodType()
    {
        return $this->methodType;
    }

    /**
     * @param string $methodType
     */
    public function setMethodType($methodType)
    {
        $this->methodType = $methodType;
    }

    /**
     * @return string JSON content from the API response
     */
    public function execute()
    {
        $auth = $this->clientAuth->GetClientAuth();
        $body = $this->getPostData();
        $options = array_merge($auth, $body);

        $response = null;

        try {
            $response = $this->client->request($this->methodType, $this->uri, $options);
        } catch (ClientException $e) {
            d($e->getResponse()
                ->getBody()
                ->getContents()
            );
            throw $e;
        }

        return $response->getBody()->getContents();
    }
}
