<?php
namespace WseCliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\FormatterHelper;

/**
 *
 * WseCommand
 *
 * @author Brian Slezak <brian@theslezaks.com>
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
     * @var $input InputInterface The InputInterface used with this command
     */
    protected $input;

    /**
     *
     * @var string $requestMethod The HTTP request method that will be executed
     */
    protected $httpMethod;

    /**
     *
     * @return string Get the request method
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

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
     * You should probably override this fuction if you need to format or manipulate the URI
     *
     * @return string The URI of the WSE API call
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     *
     * @param $uri string
     *            The URI of the WSE API call
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     *
     * @param string $httpMethod
     *            The request method that will be executed for this WseCommand
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;
        return $this;
    }

    /**
     *
     * @return \Symfony\Component\Console\Input\InputInterface
     */
    protected function getInput()
    {
        return $this->input;
    }

    /**
     *
     * @param InputInterface $input
     * @return \WseCliBundle\Command\AppStreamTargetCommand
     */
    protected function setInput(InputInterface $input)
    {
        $this->input = $input;
        return $this;
    }

    /**
     * Formats a JSON response into CLI formatted output
     *
     * @param string $json
     *            A JSON formatted string
     * @return string CLI formatted output
     */
    protected function formatOutput($json, FormatterHelper $formatter)
    {
        // Decode JSON
        $response = json_decode($json, true);
        $formattedCliOutput = '';

        if ($response['success'] == 'true') {
            $formattedCliOutput = $formatter->formatBlock([
                "[OK] $json"
            ], 'info', true);
        } else {
            $formattedCliOutput = $formatter->formatBlock([
                "[ERROR] $json"
            ], 'error', true);
        }

        return $formattedCliOutput;
    }

    abstract protected function configureArguments();

    abstract protected function configureOptions();
}