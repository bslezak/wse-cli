<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StreamTargetCommand extends Command
{
    private $stateChange;
    private $targetName;
    
    protected function configure()
    {
        $this->setName('stream-target');
        $this->setDescription('Manipulates stream targets');
        $this->setHelp('stream-target start|stop target_name');
        
        $this->setupArguments();
    }
    
    private function setupArguments()
    {
        $this->addArgument('state-change', InputArgument::REQUIRED, 'start|stop');
        $this->addArgument('target-name', InputArgument::REQUIRED, 'The name of the stream target');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->stateChange = $input->getArgument('state-change');
        $this->targetName = $input->getArgument('target-name');
        
        $output->writeln('Got parameters:');
        $output->writeln("state-change:$this->stateChange");
        $output->writeln("target-name:$this->targetName");
    }
}

