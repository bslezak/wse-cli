<?php
namespace WseCliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 *
 * @author bslezak <brian@theslezaks.com>
 *        
 */
abstract class WseCommand extends ContainerAwareCommand
{

    /**
     *
     * @var string $uri The URI of the WSE API call
     */
    protected $uri;

    /**
     *
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Command\Command::__construct()
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
        
    }
    
    public function configure() 
    {
        
        $this->configureArguments();
        $this->configureOptions();
    }
    
    /**
     *
     * @return string The URI of the WSE API call
     */
    public function getUri()
    {
        return $this->uri;
    }
    
    /**
     *
     * @param $uri string The URI of the WSE API call
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }
    
    public abstract function configureArguments();
    public abstract function configureOptions();
    
}