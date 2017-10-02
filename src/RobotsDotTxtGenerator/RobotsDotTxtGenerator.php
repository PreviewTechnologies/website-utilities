<?php

namespace Previewtechs\WebsiteUtilities\RobotsDotTxtGenerator;


use Psr\Http\Message\ResponseInterface;

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
     * @var null
     */
    protected $finalText = null;

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
     * @return $this
     */
    protected function generate()
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

        $this->finalText = $str;

        return $this;
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function respondAsTextFile(ResponseInterface $response)
    {
        if ($this->finalText === null) {
            $this->generate();
        }

        $response = $response->withStatus(200)
            ->withAddedHeader('Content-Type', 'text/plain');

        $response->getBody()->write($this->finalText);

        return $response;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        if ($this->finalText === null) {
            $this->generate();
        }

        if ($this->finalText === null) {
            return "";
        }

        return $this->finalText;
    }
}
