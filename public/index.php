<?php

require '../vendor/autoload.php';

$middleware = [
    new \MdBlog\Middleware\Demo(),
];

$application = new \MdBlog\Application(/* @todo $flysystemAdapater */);
$application->dispatchAndSend($middleware);