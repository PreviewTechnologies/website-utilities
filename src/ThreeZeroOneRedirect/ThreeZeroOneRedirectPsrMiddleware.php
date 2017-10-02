<?php
/**
 * Write something about the purpose of this file
 *
 * @author Shaharia Azam <shaharia@previewtechs.com>
 * @url https://www.previewtechs.com
 */

namespace Previewtechs\WebsiteUtilities\ThreeZeroOneRedirect;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ThreeZeroOneRedirectPsrMiddleware
 * @package Previewtechs\WebsiteUtilities\ThreeZeroOneRedirect
 */
class ThreeZeroOneRedirectPsrMiddleware
{
    /**
     * @var array
     */
    protected $paths = [];

    /**
     * ThreeZeroOneRedirectPsrMiddleware constructor.
     *
     * @param array $urls
     */
    public function __construct($urls = [])
    {
        $this->paths = $urls;
    }

    /**
     * @param array $urls
     */
    public function setPaths($urls = [])
    {
        $this->paths = $urls;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $next
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        if (in_array($request->getUri()->getPath(), array_keys($this->paths))) {
            return $response->withStatus(301)
                ->withAddedHeader('Location', $this->paths[$request->getUri()->getPath()]);
        }

        return $response = $next($request, $response);
    }
}