<?php

namespace StatsApp\Model;

/**
 * Class StatsModel
 */
class StatsModel {

    /** @var datetime */
    private $time;

    /** @var string */
    private $os;

    /** @var string */
    private $browser_name;

    /** @var string */
    private $browser_version;

    /** @var double */
    private $latitude;

    /** @var double */
    private $longitude;

    /** @var integer */
    private $screen_height;

    /** @var integer */
    private $screen_width;

    /**
     * @return datetime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param $time
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return string
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * @param $os
     * @return $this
     */
    public function setOs($os)
    {
        $this->os = $os;

        return $this;
    }

    /**
     * @return string
     */
    public function getBrowserName()
    {
        return $this->browser_name;
    }

    /**
     * @param $browser_name
     * @return $this
     */
    public function setBrowserName($browser_name)
    {
        $this->browser_name = $browser_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getBrowserVersion()
    {
        return $this->browser_version;
    }

    /**
     * @param $browser_version
     * @return $this
     */
    public function setBrowserVersion($browser_version)
    {
        $this->browser_version = $browser_version;

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return int
     */
    public function getScreenHeight()
    {
        return $this->screen_height;
    }

    /**
     * @param $screen_height
     * @return $this
     */
    public function setScreenHeight($screen_height)
    {
        $this->screen_height = $screen_height;

        return $this;
    }

    /**
     * @return int
     */
    public function getScreenWidth()
    {
        return $this->screen_width;
    }

    /**
     * @param $screen_width
     * @return $this
     */
    public function setScreenWidth($screen_width)
    {
        $this->screen_width = $screen_width;

        return $this;
    }

    public function save(){

    }
}