<?php
/**
 * Write something about the purpose of this file
 *
 * @author Shaharia Azam <shaharia@previewtechs.com>
 * @url https://www.previewtechs.com
 */

namespace Previewtechs\WebsiteUtilities\SitemapGenerator;


use Psr\Http\Message\ResponseInterface;

class SitemapGenerator
{
    /**
     * @var SitemapUrl[]
     */
    protected $urls = [];

    protected $newLine = "<br>";
    protected $tabCharacter = "\t";

    protected $finalSitemap = null;

    public function __construct()
    {
        if (function_exists('php_sapi_name') && php_sapi_name() == "cli") {
            $this->newLine = "\n";
        }
    }

    /**
     * Push single SitemapUrl
     *
     * @param SitemapUrl $url
     *
     * @return SitemapGenerator
     */
    public function addUrl(SitemapUrl $url)
    {
        $this->urls[] = $url;
        return $this;
    }

    /**
     * Add multiple SitemapUrl array
     *
     * @param $urls
     *
     * @return SitemapGenerator
     */
    public function loadUrls($urls)
    {
        foreach ($urls as $key => $value) {
            $u = new SitemapUrl($key);
            foreach ($urls[$key] as $property => $propertyValue) {
                $u->addProperty($property, $propertyValue);
            }

            $this->addUrl($u);
        }

        return $this;
    }

    /**
     * @return SitemapUrl[]
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @return $this
     */
    protected function generate()
    {
        $str = '<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
        $str .= "\n";
        $str .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        $str .= "\n";
        foreach ($this->getUrls() as $url) {
            $str .= "\t<url>\n";
            $str .= "\t\t<loc>" . htmlentities($url->getUrl()) . "</loc>\n";

            foreach ($url->getProperties() as $key => $value) {
                $str .= "\t\t<$key>{$value}</$key>\n";
            }

            $str .= "\t</url>\n";
        }
        $str .= '</urlset>';

        $this->finalSitemap = $str;

        return $this;
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function respondAsXML(ResponseInterface $response)
    {
        if (!$this->finalSitemap) {
            $this->generate();
        }

        $response = $response->withStatus(200)
            ->withAddedHeader('Content-Type', 'text/xml');

        $response->getBody()->write($this->finalSitemap);

        return $response;
    }

    public function __toString()
    {
        if (!$this->finalSitemap) {
            $this->generate();
        }

        if ($this->finalSitemap === null) {
            return "";
        }

        return $this->finalSitemap;
    }
}
