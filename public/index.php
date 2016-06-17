<?php

require '../vendor/autoload.php';

$localAdapter = new \League\Flysystem\Adapter\Local('../content');
$filesystem = new \League\Flysystem\Filesystem($localAdapter);

$middleware = [
    new \MdBlog\Middleware\ReadFile($filesystem),
    new \MdBlog\Middleware\PoweredBy(),
    new \MdBlog\Middleware\RenderMarkdown(),
];

$application = new \MdBlog\Application($filesystem);

$application->dispatchAndSend($middleware);