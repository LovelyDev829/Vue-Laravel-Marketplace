<?php

namespace App\LaravelAddons;

class ClassLoader
{
    /**
     * @var AddonManager
     */
    protected $addonManager;

    /**
     * ClassLoader constructor.
     *
     * @param AddonManager $addonManager
     */
    public function __construct(AddonManager $addonManager)
    {
        $this->addonManager = $addonManager;
    }

    /**
     * Loads the given class or interface.
     *
     * @param $class
     * @return bool|null
     */
    public function loadClass($class)
    {
        if (isset($this->addonManager->getClassMap()[$class])) {
            \Composer\Autoload\includeFile($this->addonManager->getClassMap()[$class]);

            return true;
        }
    }
}
