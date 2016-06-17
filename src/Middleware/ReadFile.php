<?php

namespace MdBlog\Middleware;

use function GuzzleHttp\Psr7\stream_for;
use League\Flysystem\Filesystem;
use mindplay\middleman\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ReadFile implements MiddlewareInterface
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        /**
         * @var Filesystem $filesystem
         */
        $filesystem = $request->getAttribute('filesystem');
        $path = $request->getUri()->getPath();

        $fileContent = $filesystem->read($path);

        $response = $response->withBody(stream_for(
            $fileContent
        ));

        /**
         * @var ResponseInterface $result
         */
        return $next($request, $response);
    }
}