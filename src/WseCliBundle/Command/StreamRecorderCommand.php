<?php

namespace WseCliBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WseCliBundle\Model\StreamRecorder;
use WseCliBundle\Model\ApiCall;

/**
 * StreamRecorderCommand.
 *
 * @author Brian Slezak <brian@theslezaks.com>
 */
class StreamRecorderCommand extends WseCommand
{
    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    public function configure()
    {
        $this->setName('stream:recorder')->setDescription('Creates a new stream recorder');

        $uri = '/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/%s/instances/_definst_/streamrecorders/%s';
        $this->setUri($uri);

        $this->setHttpMethod('POST');

        parent::configure();
    }

    /**
     * Configure command arguments.
     */
    protected function configureArguments()
    {
        $this->addArgument('new-state', InputArgument::REQUIRED, 'start|stop Start or stop the recorder');
        $this->addArgument('application-name', InputArgument::REQUIRED, 'The WSE application name');
        $this->addArgument('recorder-name', InputArgument::REQUIRED, 'The name of the recorder (must match incoming stream name!)');
    }

    /**
     * Configure command options.
     */
    protected function configureOptions()
    {
        $this->addOption('startOnKeyFrame', 's', InputOption::VALUE_NONE, 'Start the recording on the next key frame');
    }

    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Command\Command::execute()
     *
     * @return string
     */
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
         * @var FormatterHelper Formatter for CLI output
         */
        $formatter = $this->getHelper('formatter');

        return $formatter->formatBlock([
            "[OK] $json",
        ], 'info', true);
    }

    public function getUri()
    {
        $uri = $this->uri;
        $applicationName = $this->input->getArgument('application-name');
        $recorderName = $this->input->getArgument('recorder-name');
        $formattedUri = sprintf($uri, $applicationName, $recorderName);

        if ($this->input->getArgument('new-state') == 'stop') {
            $formattedUri .= '/actions/stopRecording';
        }

        return $formattedUri;
    }

    /**
     * Builds and returns a StreamRecorder.
     *
     * @return \WseCliBundle\Model\StreamRecorder
     */
    public function getStreamRecorder()
    {
        $recorderName = $this->input->getArgument('recorder-name');
        $startOnKeyframe = $this->input->getOption('startOnKeyFrame');

        // Get StreamRecorder Service
        $streamRecorder = $this->getContainer()->get('wse_cli.stream_recorder');
        $streamRecorder->setRecorderName($recorderName);
        $streamRecorder->setStartOnKeyFrame($startOnKeyframe);

        return $streamRecorder;
    }

    /**
     * @param string $uri
     *
     * @return ApiCall
     */
    protected function getApiCall($uri)
    {
        /**
         * @var APICall Use service container to retrieve ApiCall
         */
        $apiCall = $this->getContainer()->get('wse_cli.apiCall');
        $apiCall->setMethodType($this->getHttpMethod());
        $apiCall->SetUri($uri);

        return $apiCall;
    }
}
