<?php

require_once __DIR__ . '/../Kernel.php';

$kernel = new Kernel();

$kernel->init();

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();
