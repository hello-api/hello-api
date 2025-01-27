<?php

declare(strict_types=1);

use MohammadAlavi\ApiatoRector\Rules\RemoveGroupAttributeRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/config',
    ])
    ->withImportNames(false, false, false, true)
    ->withRules([
        RemoveGroupAttributeRector::class,
    ]);
// uncomment to reach your current PHP version
// ->withPhpSets()
//    ->withTypeCoverageLevel(0);
