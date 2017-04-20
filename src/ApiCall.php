<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

/**
 * @author bslezak <brian@theslezaks.com>
 *
 */
class ApiCall
{

    /**
     *
     * @var Client
     */
    private $client;

    /**
     *
     * @var string
     */
    private $uri;

    /**
     *
     * @var APIAuth
     */
    private $clientAuth;

    /**
     * @var string
     */
    private $methodType;
    

    public function __construct(Client $client, APIAuth $clientAuth)
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
        
        $response = $this->client->request($this->methodType,$this->uri,$auth);
        
        return $response->getBody()->getContents();
    }
   
}

