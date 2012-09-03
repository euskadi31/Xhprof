<?php
/**
 * @package     Xhprof
 * @author      Axel Etcheverry <axel@etcheverry.biz>
 * @copyright   Copyright (c) 2012 Axel Etcheverry (https://twitter.com/euskadi31)
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @namespace
 */
namespace Application;

if(!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    echo "Please execute make && make install";
    exit;
}

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