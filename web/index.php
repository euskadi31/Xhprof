<?php

namespace Application;

use Silex;
use Xhprof;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__ . '/config.php';

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

$app['xhprof'] = function(Silex\Application $app) {
    return new Xhprof\Profiler($app['profiler']);
};

require __DIR__ . '/controller/index.php';
require __DIR__ . '/controller/report.php';


$app->run();