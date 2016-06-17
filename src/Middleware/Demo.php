<?php

namespace MdBlog\Middleware;

use function GuzzleHttp\Psr7\stream_for;
use mindplay\middleman\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Demo implements MiddlewareInterface
{
    function __invoke(RequestInterface $request, ResponseInterface $response, callable $next) {
        return $response->withBody(
            stream_for(json_encode([
                $request->getMethod(),
                $request->getUri()->getPath()
            ], JSON_PRETTY_PRINT))
        );
    }
}