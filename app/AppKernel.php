<?php
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use WseCliBundle\FirstExecutionTasks;

class AppKernel extends Kernel
{

    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new WseCliBundle\WseCliBundle()
        ];
        
        if (in_array($this->getEnvironment(), [
            'dev',
            'test'
        ], true)) {
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }
        
        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        $home = preg_replace('#^(\$HOME|~)(/|$)#', rtrim(getenv('HOME') ?: getenv('USERPROFILE'), '/\\'), '$HOME');
        return $home . '/.wsecli/var/cache/' . $this->getEnvironment();
    }

    public function getLogDir()
    {
        $home = preg_replace('#^(\$HOME|~)(/|$)#', rtrim(getenv('HOME') ?: getenv('USERPROFILE'), '/\\'), '$HOME');
        return $home . '/.wsecli/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        FirstExecutionTasks::checkFistTimeConfig($this->getRootDir());
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
