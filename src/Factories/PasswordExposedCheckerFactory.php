<?php

namespace JordJD\LaravelPasswordExposedValidationRule\Factories;

use JordJD\DOFileCachePSR6\CacheItemPool;
use JordJD\PasswordExposed\Interfaces\PasswordExposedCheckerInterface;
use JordJD\PasswordExposed\PasswordExposedChecker;

/**
 * Class PasswordExposedCheckerFactory.
 */
class PasswordExposedCheckerFactory
{
    /**
     * Creates and returns an instance of PasswordExposedChecker.
     *
     * @return PasswordExposedCheckerInterface
     */
    public function instance()
    {
        $cache = new CacheItemPool();

        $cache->changeConfig([
            'cacheDirectory' => $this->getCacheDirectory(),
        ]);

        return new PasswordExposedChecker(null, $cache);
    }

    /**
     * Gets the directory to store the cache files.
     *
     * @return string
     */
    private function getCacheDirectory()
    {
        if (function_exists('storage_path')) {
            return storage_path('app/password-exposed-cache/');
        }

        return sys_get_temp_dir().'/password-exposed-cache/';
    }
}
