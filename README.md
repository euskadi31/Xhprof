XHProf GUI for PHP5.3+
======================

Install
-------

    make && make install
    
or

    curl -s https://getcomposer.org/installer | php
    php composer.phar install

Usage
-----

The examples are a good place to start. The minimal you'll need to
have is:

``` php
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

$xhprof->save($xhprof_data);

echo $xhprof->getProfilerUrl() . PHP_EOL;
?>
```

License
-------

The MIT License

Copyright (c) 2012 Axel Etcheverry

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.