<?php

$app['reportRequest'] = function(Silex\Application $app) {
    return new Xhprof\Report\Request($app['request']);
};



$app->get('/report/diff/{namespace}/{run1}/{run2}/', function(Silex\Application $app) {
    
    $namespace = $app['request']->get('namespace');
    $run = $app['request']->get('run');
    
    $xhprof_data = $app['xhprof']->get($run, $namespace);
    
    print_r($xhprof_data);
    
    
    
    
    
    return $app['twig']->render('report.twig', array(
        'run_id' => $run,
        'namespace' => $namespace
    ));
});


$app->get('/report/{namespace}/{run}/', function(Silex\Application $app) {
    
    $namespace = $app['request']->get('namespace');
    $run = $app['request']->get('run');
    
    $report = new Xhprof\Profiler\Report($app['xhprof']->get($run, $namespace));
    $report->sortBy('wt');
    
    return $app['twig']->render('report.twig', array(
        'run_id'    => $run,
        'namespace' => $namespace,
        'report'    => $report
    ));
});