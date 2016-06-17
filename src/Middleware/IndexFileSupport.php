<?php

namespace MdBlog\Middleware;

use function GuzzleHttp\Psr7\stream_for;
use League\Flysystem\Filesystem;
use mindplay\middleman\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class IndexFileSupport implements MiddlewareInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var array
     */
    private $allowedIndexFiles;

    /**
     * ReadFile constructor.
     * @param Filesystem $filesystem
     * @param array $allowedIndexFiles
     */
    public function __construct(Filesystem $filesystem, $allowedIndexFiles = ['index.md'])
    {
        $this->filesystem = $filesystem;
        $this->allowedIndexFiles = $allowedIndexFiles;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        /**
         * @var Filesystem $filesystem
         */
        $path = $request->getUri()->getPath();

        if (pathinfo($path, PATHINFO_EXTENSION) != '') {
            return $next($request, $response);
        }

        foreach ($this->allowedIndexFiles as $allowedIndexFile) {
            $newPath = $path . '/' . $allowedIndexFile;

            if (!$this->filesystem->has($newPath)) {
                continue;
            }

            $request = $request->withUri(
                $request->getUri()->withPath($newPath)
            );

            break;
        }

        /**
         * @var ResponseInterface $result
         */
        return $next($request, $response);
    }
}