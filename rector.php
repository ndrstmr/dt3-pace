<?php
return Rector\Config\RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/Classes',
    ])
    ->withPhpSets()
    ->withPhpVersion(80200);
