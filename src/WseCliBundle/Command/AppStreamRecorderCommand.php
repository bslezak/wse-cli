<?php
namespace WseCliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WseCliBundle\Model\StreamRecorder;
use WseCliBundle\Model\ApiCall;

class AppStreamRecorderCommand extends ContainerAwareCommand
{

    const URI_TEMPLATE = "/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/%s/instances/_definst_/streamrecorders/%s";

    const POST_DATA = '{"instanceName":"","fileVersionDelegateName":"","serverName":"","recorderName":"leawood_sanctuary","currentSize":0,"segmentSchedule":"","startOnKeyFrame":true,"outputPath":"","currentFile":"","saveFieldList":[""],"recordData":false,"applicationName":"","moveFirstVideoFrameToZero":false,"recorderErrorString":"","segmentSize":0,"defaultRecorder":false,"splitOnTcDiscontinuity":false,"version":"","baseFile":"","segmentDuration":0,"recordingStartTime":"","fileTemplate":"","backBufferTime":0,"segmentationType":"","currentDuration":0,"fileFormat":"","recorderState":"","option":""}';

    const METHOD = "POST";

    protected function configure()
    {
        $this->setName('app:stream-recorder')
            ->setDescription('Creates a new stream recorder');
        
        $this->configureArguments();
        $this->configureOptions();
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
        $applicationName = $input->getArgument('application-name');
        $recorderName = $input->getArgument('recorder-name');
        $startOnKeyframe = $input->getOption('startOnKeyFrame');
        
        $streamRecorder = new StreamRecorder();
        $streamRecorder->setRecorderName($recorderName);
        $streamRecorder->setStartOnKeyFrame($startOnKeyframe);
        
        $uri = $this->getFormattedUri($input);
        $apiCall = $this->getApiCall($uri);
        
        $postData = json_encode($streamRecorder);
        
        $apiCall->setPostData($postData);
        
        return 0;

    }

    /**
     *
     * @return string Fully formatted uri
     */
    protected function getFormattedUri(InputInterface $input)
    {
        $applicationName = $input->getArgument('application-name');
        $recorderName = $input->getArgument('recorder-name');
        
        return sprintf(self::URI_TEMPLATE, $applicationName, $recorderName);
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
