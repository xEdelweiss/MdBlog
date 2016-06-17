<?php

namespace MdBlog\Middleware;

use GuzzleHttp\Psr7\AppendStream;
use function GuzzleHttp\Psr7\stream_for;
use mindplay\middleman\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PoweredBy implements MiddlewareInterface
{
    function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        /**
         * @var ResponseInterface $result
         */
        $result = $next($request, $response);

        $path = $request->getUri()->getPath();

        return $result->withBody(new AppendStream([
            $result->getBody(),
            stream_for("<hr/>Powered by MdBlog ({$path})"),
        ]));
    }
}