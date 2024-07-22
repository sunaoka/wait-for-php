<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$dirs = [
    __DIR__.'/src',
    __DIR__.'/tests',
];

$rules = [
    '@Symfony' => true,
    'phpdoc_to_comment' => [
        'allow_before_return_statement' => true,
    ],
];

return (new Config())
    ->setRules($rules)
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setFinder(Finder::create()->in($dirs)->append([__FILE__]))
;
