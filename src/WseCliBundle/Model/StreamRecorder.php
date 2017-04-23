<?php
namespace WseCliBundle\Model;


/**
 * @author bslezak <brian@theslezaks.com>
 *
 */
class StreamRecorder implements \JsonSerializable
{
    protected $recorderName;
    protected $startOnKeyFrame; 
    protected $recordData;
    
    /**
     * @return the $name
     */
    public function getRecorderName()
    {
        return $this->recorderName;
    }

    /**
     * @return the $startOnKeyFrame
     */
    public function getStartOnKeyFrame()
    {
        return $this->startOnKeyFrame;
    }

    /**
     * @return the $recordData
     */
    public function getRecordData()
    {
        return $this->recordData;
    }

    /**
     * @param string $name
     */
    public function setRecorderName($name)
    {
        $this->recorderName = $name;
    }

    /**
     * @param boolean $startOnKeyFrame
     */
    public function setStartOnKeyFrame($startOnKeyFrame)
    {
        $this->startOnKeyFrame = $startOnKeyFrame;
    }

    /**
     * @param boolean $recordData
     */
    public function setRecordData($recordData)
    {
        $this->recordData = $recordData;
    }

    public function __construct()
    {
        $this->startOnKeyFrame = true;
        $this->recordData = false;
    }
    
    /**
     * @return string
     */
    public function jsonSerialize()
    {
        $objArray = get_object_vars($this);
        
        $defaultOptions = [
            "instanceName" => "",
            "fileVersionDelegateName" => "",
            "serverName" => "",
            "currentSize" => 0,
            "segmentSchedule" => "",
            "outputPath" => "",
            "currentFile" => "",
            "saveFieldList" => [
                ""
            ],
            "applicationName" => "",
            "moveFirstVideoFrameToZero" => false,
            "recorderErrorString" => "",
            "segmentSize" => 0,
            "defaultRecorder" => false,
            "splitOnTcDiscontinuity" => false,
            "version" => "",
            "baseFile" => "",
            "segmentDuration" => 0,
            "recordingStartTime" => "",
            "fileTemplate" => "",
            "backBufferTime" => 0,
            "segmentationType" => "",
            "currentDuration" => 0,
            "fileFormat" => "",
            "recorderState" => "",
            "option" => ""
        ];
        
        return array_merge($objArray,$defaultOptions);
    }
}

