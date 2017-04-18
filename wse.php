#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Command\StreamTargetCommand;

$application = new Application();

// ... register commands
$application->add(new StreamTargetCommand());

$application->run();