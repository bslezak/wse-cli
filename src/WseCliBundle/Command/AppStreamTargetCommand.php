<?php
namespace WseCliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WseCliBundle\Model\ApiCall;

class AppStreamTargetCommand extends ContainerAwareCommand
{

    const URI_TEMPLATE = "/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/%s/pushpublish/mapentries/%s/actions/%s";

    const METHOD = "PUT";

    protected function configure()
    {
        $this->setName('app:stream-target');
        $this->setDescription('Manipulates stream targets');
        $this->setHelp('app:stream-target enable|disable application_name target_name');
        
        $this->setupArguments();
    }

    protected function setupArguments()
    {
        $this->addArgument('state-change', InputArgument::REQUIRED, 'enable|disable');
        $this->addArgument('application-name', InputArgument::REQUIRED, 'The WSE application name');
        $this->addArgument('target-name', InputArgument::REQUIRED, 'The name of the stream target');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $uri = $this->getFormattedUri($input);
        
        
        /**
         * @var ApiCall $apiCall
         */
        $apiCall = $this->getApiCall($uri);
        
        // Make the call to the API and get JSON response
        $json = $apiCall->execute();
        
        $formattedCliOutput = $this->formatOutput($json);
        
        $output->writeln($formattedCliOutput);
    }

    /**
     *
     * @return string Fully formatted uri
     */
    protected function getFormattedUri(InputInterface $input)
    {
        $stateChange = $input->getArgument('state-change');
        $targetName = $input->getArgument('target-name');
        $applicationName = $input->getArgument('application-name');
        
        return sprintf(self::URI_TEMPLATE, $applicationName, $targetName, $stateChange);
    }

    protected function getApiCall($uri)
    {
        /**
         *
         * @var APICall $apiCall Use service container to retrieve ApiCall
         */
        $apiCall = $this->getContainer()->get('wse_cli.apiCall');
        
        // TODO: Move this to Interface so it's the only two things that have to be configured for a command
        $apiCall->setMethodType(self::METHOD);
        $apiCall->SetUri($uri);
        
        return $apiCall;
    }

    protected function formatOutput($json)
    {
        // Decode JSON
        $response = json_decode($json, true);
        $formattedCliOutput = '';
        
        /**
         *
         * @var FormatterHelper $formatter Formatter for CLI output
         */
        $formatter = $this->getHelper('formatter');
        
        if ($response['success'] == 'true')
        {
            $formattedCliOutput = $formatter->formatBlock([
                "[OK] $json"
            ], 'info', true);
        } else
        {
            $formattedCliOutput = $formatter->formatBlock([
                "[ERROR] $json"
            ], 'error', true);
        }
        
        return $formattedCliOutput;
    }
}
