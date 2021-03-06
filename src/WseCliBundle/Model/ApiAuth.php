<?php

namespace WseCliBundle\Model;

/**
 * ApiAuth.
 *
 * @author Brian Slezak <brian@theslezaks.com>
 */
class ApiAuth
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string Should be one of none|basic|digest
     */
    private $authMethod;

    /**
     * @param string $username
     * @param string $password
     * @param string $authMethod
     *                           none|digest|basic
     */
    public function __construct($username, $password, $authMethod = 'none')
    {
        $this->authMethod = $authMethod;
        $this->password = $password;
        $this->username = $username;
    }

    public function GetClientAuth()
    {
        // Set up clientAuth variable
        $clientAuth = null;

        // switch on authMethod
        switch ($this->authMethod) {
            case 'basic':
                $clientAuth = [
                    'auth' => [
                        $this->username,
                        $this->password,
                    ],
                ];
                break;

            case 'digest':
                $clientAuth = [
                    'auth' => [
                        $this->username,
                        $this->password,
                        $this->authMethod,
                    ],
                ];
                break;

            default:
                break;
        }

        return $clientAuth;
    }
}
