<?php
namespace WseCliBundle;

use Composer\Console\Application;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\Output;

class FirstExecutionTasks
{

    public static function checkFistTimeConfig($rootDir)
    {
        $paths = array(
            $rootDir . '/config'
        );
        $locater = new FileLocator($paths);
        try {
            $locater->locate('parameters.yml');
        } catch (\Exception $e) {
            
            // parameters.yml was not found so run script to create it
            $composer = new Application();
            
            $args = array(
                0 => "composer",
                1 => "run-script",
                2 => "symfony-scripts"
            );
            $input = new ArgvInput($args);
            
            $stdout = fopen('php://stdout', 'w');
            $output = new ConsoleOutput(Output::VERBOSITY_NORMAL);
            
            $composer->run($input, $output);
        }
    }
}
