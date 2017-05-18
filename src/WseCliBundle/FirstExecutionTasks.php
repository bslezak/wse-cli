<?php
namespace WseCliBundle;

use Composer\Console\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\Output;

/**
 * FirstExecutionTasks
 * Performs first time execution configuration tasks
 * 
 * @author Brian Slezak <brian@theslezaks.com>
 *        
 */
class FirstExecutionTasks
{

    /**
     *
     * @param string $rootDir
     *            The root folder of the AppKernel
     */
    public static function checkFistTimeConfig($rootDir)
    {
        // Search config path
        $paths = array(
            $rootDir . '/config'
        );
        $locater = new FileLocator($paths);
        try {
            
            // Try to located the parameters.yml file. If it doesn't exist catch the Exception and create it
            $locater->locate('parameters.yml');
        } catch (\Exception $e) {
            
            // parameters.yml was not found so create an instance of composer to run scripts
            $composer = new Application();
            
            // Simulate command line argv
            $args = array(
                0 => "composer",
                1 => "run-script",
                2 => "symfony-scripts"
            );
            $input = new ArgvInput($args);
            
            // Get console output for user input
            $output = new ConsoleOutput(Output::VERBOSITY_NORMAL);
            
            // Run composer which will set up necessary files and prompt user for input
            $composer->run($input, $output);
        }
    }
}
