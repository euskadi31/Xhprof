<?php
$app->get('/', function(Silex\Application $app) { 
    return $app['twig']->render('index.twig', array(
        'name' => 'Axel',
    ));
});