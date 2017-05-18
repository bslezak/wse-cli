<?php

namespace WseCliBundle;

use Symfony\Bundle\FrameworkBundle\Console\Application;

class Application extends Application
{
    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Application::run()
     */
    public function run($input, $output)
    {
        // Service Container
        $container = $this->getKernel()->getContainer();

        // Run first time tasks
        FirstExecutionTasks::checkFistTimeConfig($container, $input, $output);

        // Run
        parent::run($input, $output);
    }
}