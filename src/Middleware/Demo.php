<?php

namespace MdBlog\Middleware;

use function GuzzleHttp\Psr7\stream_for;
use mindplay\middleman\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Demo implements MiddlewareInterface
{
    function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        /**
         * @var ResponseInterface $result
         */
        $result = $next($request, $response);

        return $result->withBody(new \GuzzleHttp\Psr7\AppendStream([
            $result->getBody(),
            stream_for('<hr/>Powered by MdBlog'),
        ]));
    }
}