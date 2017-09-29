<?php

namespace Previewtechs\WebsiteUtilities\RobotsDotTxtGenerator;


class RobotsDotTxtRules
{
    protected $allowedPaths = [];
    protected $disallowedPaths = [];

    protected $userAgent = '*';

    /**
     * RobotsDotTxtRules constructor.
     *
     * @param $userAgent
     */
    public function __construct($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @param $path
     *
     * @return $this
     */
    public function allow($path)
    {
        if (is_array($path)) {
            $this->allowedPaths = array_merge($this->allowedPaths, $path);
        }

        if (is_string($path)) {
            $this->allowedPaths[] = $path;
        }

        return $this;
    }

    /**
     * @param $path
     *
     * @return $this
     */
    public function disallow($path)
    {
        if (is_array($path)) {
            $this->disallowedPaths = array_merge($this->disallowedPaths, $path);
        }

        if (is_string($path)) {
            $this->disallowedPaths[] = $path;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedPaths()
    {
        return $this->allowedPaths;
    }

    /**
     * @return array
     */
    public function getDisallowedPaths()
    {
        return $this->disallowedPaths;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }
}