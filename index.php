<?php

require __DIR__ . '/vendor/autoload.php';

use Arrayzy\ArrayImitator as A;

$a = A::create(['a', 'b', 'c']);

$a->debug();
