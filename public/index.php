<?php

require '../vendor/autoload.php';

$middleware = [
    new \MdBlog\Middleware\ReadFile(),
    new \MdBlog\Middleware\Demo(),
    new \MdBlog\Middleware\RenderMarkdown(),
];

$localAdapter = new \League\Flysystem\Adapter\Local('../content');

$application = new \MdBlog\Application($localAdapter);
$application->dispatchAndSend($middleware);