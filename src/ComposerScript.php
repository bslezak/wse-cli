<?php
use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use Incenteev;

class ComposerScript
{

    public static function runScripts(Event $event)
    {
        $vendorDir = $event->getComposer()
            ->getConfig()
            ->get('vendor-dir');
        require $vendorDir . '/autoload.php';

        Incenteev\ParameterHandler\ScriptHandler::buildParameters($event);
    }
}