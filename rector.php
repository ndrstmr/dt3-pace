<?php
declare(strict_types=1);

use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/Classes',
    ]);
    $rectorConfig->phpVersion(80200);
    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon.dist');
};
