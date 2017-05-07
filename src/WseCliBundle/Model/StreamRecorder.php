<?php
namespace WseCliBundle\Model;

use Symfony\Component\Console\Application;
use Symfony\Component\Config\FileLocator;

/**
 *
 * StreamRecorder
 *
 * @author Brian Slezak <brian@theslezaks.com>
 * @version @application_version@
 *
 */
class StreamRecorder implements \JsonSerializable
{

    protected $recorderName;

    protected $startOnKeyFrame;

    protected $recordData;

    protected $loadDefaults;

    protected $defaults;

    /**
     * Contruct a StreamRecorder
     *
     * @param bool $loadDefaults
     *            Optionally load defaults. true|false $loadDefaults = false [Defaults specified in Resources\defaults.yml under "stream-recorder"]
     */
    public function __construct($loadDefaults = false)
    {
        $this->loadDefaults = $loadDefaults;
        $this->startOnKeyFrame = true;
        $this->recordData = false;
    }

    /**
     *
     * @return bool StreamRecorder default settings
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     *
     * @param array $defaults
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
    }

    /**
     *
     * @return the $name
     */
    public function getRecorderName()
    {
        return $this->recorderName;
    }

    /**
     *
     * @return the $startOnKeyFrame
     */
    public function getStartOnKeyFrame()
    {
        return $this->startOnKeyFrame;
    }

    /**
     *
     * @return the $recordData
     */
    public function getRecordData()
    {
        return $this->recordData;
    }

    /**
     *
     * @param string $name
     */
    public function setRecorderName($name)
    {
        $this->recorderName = $name;
    }

    /**
     *
     * @param boolean $startOnKeyFrame
     */
    public function setStartOnKeyFrame($startOnKeyFrame)
    {
        $this->startOnKeyFrame = $startOnKeyFrame;
    }

    /**
     *
     * @param boolean $recordData
     */
    public function setRecordData($recordData)
    {
        $this->recordData = $recordData;
    }

    /**
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $objArray = get_object_vars($this);

        // Unset defaults and loadDefaults as they shouldn't be serialized
        unset($objArray['defaults']);
        unset($objArray['loadDefaults']);

        // Declare defaultOptions array as empty
        $defaultOptions = [];

        // If we should load defaults, populate $defaultOptions
        if ($this->loadDefaults) {
            $defaultOptions = $this->getDefaults();
        }

        return array_merge($objArray, $defaultOptions);
    }
}

