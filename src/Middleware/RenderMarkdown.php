<?php

namespace MdBlog\Middleware;

use function GuzzleHttp\Psr7\stream_for;
use League\CommonMark\CommonMarkConverter;
use mindplay\middleman\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RenderMarkdown implements MiddlewareInterface
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        /**
         * @var ResponseInterface $result
         */
        $result = $next($request, $response);

        if (pathinfo($request->getUri()->getPath(), PATHINFO_EXTENSION) != 'md') {
            return $result;
        }

        $body = $response->getBody()->getContents();
        $converter = new CommonMarkConverter();

        return $response->withBody(stream_for(
            $converter->convertToHtml($body)
        ));
    }
}