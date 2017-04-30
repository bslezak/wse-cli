<?php
namespace WseCliBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WseCliBundle\Model\StreamRecorder;
use WseCliBundle\Model\ApiCall;

class AppStreamRecorderCommand extends WseCommand
{
    public function configure()
    {
        $this->setName('app:stream-recorder')
            ->setDescription('Creates a new stream recorder');
        
        $uri = "/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/%s/instances/_definst_/streamrecorders/%s";
        $this->setUri($uri);
        
        $this->setHttpMethod('POST');

    }

    protected function configureArguments()
    {
        $this->addArgument('application-name', InputArgument::OPTIONAL, 'The WSE application name')
            ->addArgument('recorder-name', InputArgument::OPTIONAL, 'The name of the recorder (must match incoming stream name!)');
    }

    protected function configureOptions()
    {
        $this->addOption('startOnKeyFrame', 'sof', InputOption::VALUE_NONE, 'Start the recording on the next key frame');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$this->setInput($input);
        
        $uri = $this->getUri();
        $apiCall = $this->getApiCall($uri);
        
        $streamRecorder = $this->getStreamRecorder();
        $postData = json_encode($streamRecorder);
        
        $apiCall->setPostData($postData);
        
        $json = $apiCall->execute();
        
        /**
         *
         * @var FormatterHelper $formatter Formatter for CLI output
         */
        $formatter = $this->getHelper('formatter');
        
        return $formatter->formatBlock(
            ["[OK] $json"],
            'info',
            true
        );

    }
    
    /**
     * Builds and returns a StreamRecorder
     * @return \WseCliBundle\Model\StreamRecorder
     */
    public function getStreamRecorder() {
    	
    	$recorderName = $this->input->getArgument('recorder-name');
    	$startOnKeyframe = $this->input->getOption('startOnKeyFrame');
    	
    	$streamRecorder = new StreamRecorder();
    	$streamRecorder->setRecorderName($recorderName);
    	$streamRecorder->setStartOnKeyFrame($startOnKeyframe);
    	
    	return $streamRecorder;
    }

    
    /**
     *
     * @param string $uri            
     * @return ApiCall
     */
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
}
