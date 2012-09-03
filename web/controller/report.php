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

$app['reportRequest'] = function(Silex\Application $app) {
    return new Xhprof\Report\Request($app['request']);
};

$app->get('/report/{namespace}/{run}/', function(Silex\Application $app) {
    
    $namespace = $app['request']->get('namespace');
    $run = $app['request']->get('run');
    $symbol = $app['request']->get('symbol');
    
    if(empty($symbol)) {
        $report = new Xhprof\Profiler\Report($app['xhprof']->get($run, $namespace));
        $report->sortBy($app['request']->get('sort', 'wt'));

        $view = 'report.twig';
    } else {
        
        $report = new Xhprof\Profiler\Report($app['xhprof']->get($run, $namespace));
        $report->sortBy($app['request']->get('sort', 'wt'));
        
        $view = 'inspector.twig';
    }
    
    return $app['twig']->render($view, array(
        'run_id'    => $run,
        'namespace' => $namespace,
        'report'    => $report
    ));
});