<?php

namespace Demo;

function bar($x) {
    if ($x > 0) {
        bar($x - 1);
    }
}

function foo() {
    for ($idx = 0; $idx < 5; $idx++) {
        bar($idx);
        $x = strlen("abc");
    }
}


// start profiling
xhprof_enable();

// run program
foo();

// stop profiler
$xhprof_data = xhprof_disable();

require_once __DIR__ . '/../vendor/autoload.php';

$xhprof = new \Xhprof\Profiler(include __DIR__ . '/config.php');

$run_id = $xhprof->save($xhprof_data);

echo $xhprof->getProfilerUrl() . PHP_EOL;