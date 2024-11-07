<?php

use PhpCsFixer\{Config, Finder};

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('var');

return (new Config())
    ->setRules([
        '@PSR12' => true,
        'ordered_imports' => true,
    ])
    ->setFinder($finder);