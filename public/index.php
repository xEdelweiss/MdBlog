<?php

require '../vendor/autoload.php';

$localAdapter = new \League\Flysystem\Adapter\Local('../content');
$filesystem = new \League\Flysystem\Filesystem($localAdapter);

$middleware = [
    new \MdBlog\Middleware\IndexFileSupport($filesystem, ['index.json', 'index.html', 'index.md']),
    new \MdBlog\Middleware\ReadFile($filesystem),
    new \MdBlog\Middleware\PoweredBy(),
    new \MdBlog\Middleware\RenderMarkdown(),
];

$application = new \MdBlog\Application();

$application->dispatchAndSend($middleware);