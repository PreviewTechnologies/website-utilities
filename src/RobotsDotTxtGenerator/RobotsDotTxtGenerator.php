<?php

namespace Previewtechs\WebsiteUtilities\RobotsDotTxtGenerator;


class RobotsDotTxtGenerator
{
    /**
     * @var RobotsDotTxtRules []
     */
    protected $rules = [];

    /**
     * @var string
     */
    protected $newLine = "<br>";

    /**
     * RobotsDotTxtGenerator constructor.
     */
    public function __construct()
    {
        if (function_exists('php_sapi_name') && php_sapi_name() == "cli") {
            $this->newLine = "\n";
        }
    }

    /**
     * @param RobotsDotTxtRules $robotsDotTxtRules
     *
     * @return $this
     */
    public function addRules(RobotsDotTxtRules $robotsDotTxtRules)
    {
        $this->rules[] = $robotsDotTxtRules;
        return $this;
    }

    /**
     * @return RobotsDotTxtRules[]
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $str = "";

        foreach ($this->getRules() as $rule) {
            $str .= sprintf("User-Agent: %s", $rule->getUserAgent()) . $this->newLine;

            foreach ($rule->getAllowedPaths() as $allowedPath) {
                $str .= sprintf("Allowed: %s", $allowedPath) . $this->newLine;
            }

            foreach ($rule->getDisallowedPaths() as $allowedPath) {
                $str .= sprintf("Disallow: %s", $allowedPath) . $this->newLine;
            }

            $str .= $this->newLine;
        }

        return $str;
    }
}