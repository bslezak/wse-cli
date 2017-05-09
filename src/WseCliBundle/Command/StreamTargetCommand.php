<?php
namespace WseCliBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WseCliBundle\Model\ApiCall;

/**
 *
 * StreamTargetCommand
 *
 * @author Brian Slezak <brian@theslezaks.com>
 *
 */
class StreamTargetCommand extends WseCommand
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \WseCliBundle\Command\WseCommand::configure()
     */
    public function configure()
    {
        $uri = "/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/%s/pushpublish/mapentries/%s/actions/%s";
        $this->setUri($uri);
        
        $this->setHttpMethod('PUT');
        
        $this->setName('stream:target');
        $this->setDescription('Manipulates stream targets');
        $this->setHelp('app:stream-target enable|disable application_name target_name');
        parent::configure();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \WseCliBundle\Command\WseCommand::configureOptions()
     */
    protected function configureArguments()
    {
        $this->addArgument('state-change', InputArgument::REQUIRED, 'enable|disable');
        $this->addArgument('application-name', InputArgument::REQUIRED, 'The WSE application name');
        $this->addArgument('target-name', InputArgument::REQUIRED, 'The name of the stream target');
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \WseCliBundle\Command\WseCommand::configureOptions()
     */
    protected function configureOptions()
    {
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \WseCliBundle\Command\WseCommand::getUri()
     */
    public function getUri()
    {
        $stateChange = $this->input->getArgument('state-change');
        $targetName = $this->input->getArgument('target-name');
        $applicationName = $this->input->getArgument('application-name');
        
        return sprintf($this->uri, $applicationName, $targetName, $stateChange);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setInput($input);
        
        /**
         *
         * @var ApiCall $apiCall
         */
        $apiCall = $this->getApiCall();
        
        // Make the call to the API and get JSON response
        $json = $apiCall->execute();
        
        /**
         *
         * @var FormatterHelper $formatter Formatter for CLI output
         */
        $formatter = $this->getHelper('formatter');
        $formattedCliOutput = $this->formatOutput($json, $formatter);
        
        $output->writeln($formattedCliOutput);
    }

    /**
     * Creates an ApiCall
     *
     * @return \WseCliBundle\Model\ApiCall
     */
    protected function getApiCall()
    {
        
        /**
         *
         * @var APICall $apiCall Use service container to retrieve ApiCall
         */
        $apiCall = $this->getContainer()->get('wse_cli.apiCall');
        
        $apiCall->setMethodType($this->getHttpMethod());
        $apiCall->SetUri($this->getUri());
        
        return $apiCall;
    }
}
