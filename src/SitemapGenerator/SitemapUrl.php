<?php
/**
 * Write something about the purpose of this file
 *
 * @author Shaharia Azam <shaharia@previewtechs.com>
 * @url https://www.previewtechs.com
 */

namespace Previewtechs\WebsiteUtilities\SitemapGenerator;

/**
 * Class SitemapUrl
 * @package Previewtechs\WebsiteUtilities\SitemapGenerator
 */
class SitemapUrl
{
    /**
     * @var null
     */
    protected $url = null;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * SitemapUrl constructor.
     *
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    public function addProperty($key, $value)
    {
        $this->properties[$key] = $value;
    }

    /**
     * @return null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }
}