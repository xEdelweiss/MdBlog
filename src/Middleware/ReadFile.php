<?php

namespace MdBlog\Middleware;

use function GuzzleHttp\Psr7\stream_for;
use League\Flysystem\Filesystem;
use mindplay\middleman\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ReadFile implements MiddlewareInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * ReadFile constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        /**
         * @var Filesystem $filesystem
         */
        $path = $request->getUri()->getPath();
        $fileContent = $this->filesystem->read($path);

        $response = $response->withBody(stream_for(
            $fileContent
        ));

        /**
         * @var ResponseInterface $result
         */
        return $next($request, $response);
    }
}