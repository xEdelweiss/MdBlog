<?php

namespace MdBlog;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Filesystem;
use mindplay\middleman\Dispatcher;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Application
 * @package MdBlog
 * @author Michael Sverdlikovsky
 */
class Application
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Application constructor.
     * @param AbstractAdapter $adapter
     */
    public function __construct(AbstractAdapter $adapter)
    {
        $filesystem = new Filesystem($adapter);
        // $filesystem->addPlugin(new ListFiles());

        $this->filesystem = $filesystem;
    }

    /**
     * @param array $middleware
     * @param RequestInterface|null $request
     * @return ResponseInterface
     */
    public function dispatch(array $middleware, RequestInterface $request = null)
    {
        if (is_null($request)) {
            $request = ServerRequest::fromGlobals();
        }

        $request = $request->withAttribute('filesystem', $this->filesystem);

        $response = new Response();

        $dispatcher = new Dispatcher($middleware);
        return $dispatcher->dispatch($request, $response);
    }

    /**
     * @param array $middleware
     * @param RequestInterface|null $request
     */
    public function dispatchAndSend(array $middleware, RequestInterface $request = null)
    {
        $response = $this->dispatch($middleware, $request);
        $this->send($response);
    }

    /**
     * @param ResponseInterface $response
     */
    public function send(ResponseInterface $response)
    {
        foreach ($response->getHeaders() as $name => $values) {
            header($name . ': ' . implode(', ', $values));
        }

        echo $response->getBody();
    }
}