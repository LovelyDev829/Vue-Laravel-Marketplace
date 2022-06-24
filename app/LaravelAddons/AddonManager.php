<?php

namespace App\LaravelAddons;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class AddonManager
{
    private $app;

    /**
     * @var AddonManager
     */
    private static $instance = null;

    /**
     * @var string
     */
    protected $addonDirectory;

    /**
     * @var array
     */
    protected $addons = [];

    /**
     * @var array
     */
    protected $classMap = [];

    /**
     * @var AddonExtender
     */
    protected $addonExtender;

    /**
     * AddonManager constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app             = $app;
        $this->addonDirectory = $app->path() . DIRECTORY_SEPARATOR . 'Addons';

        $this->bootAddons();

        $this->registerClassLoader();
    }

    /**
     * Registers addon autoloader.
     */
    private function registerClassLoader()
    {
        spl_autoload_register([new ClassLoader($this), 'loadClass'], true, true);
    }

    /**
     * @param $app
     * @return AddonManager
     */
    public static function getInstance($app)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($app);
        }

        return self::$instance;
    }

    protected function bootAddons()
    {
        foreach (Finder::create()->in($this->addonDirectory)->directories()->depth(0) as $dir) {
            /** @var SplFileInfo $dir */
            $directoryName = $dir->getBasename();

            $addonClass = $this->getAddonClassNameFromDirectory($directoryName);

            if (!class_exists($addonClass)) {
                dd('Addon ' . $directoryName . ' needs a ' . $directoryName . 'Addon class.');
            }

            try {
                $addon = $this->app->makeWith($addonClass, [$this->app]);
            } catch (\ReflectionException $e) {
                dd('Addon ' . $directoryName . ' could not be booted: "' . $e->getMessage() . '"');
                exit;
            }

            if (!($addon instanceof Addon)) {
                dd('Addon ' . $directoryName . ' must extends the Addon Base Class');
            }

            $addon->boot();

            $this->addons[$addon->name] = $addon;
        }
    }

    /**
     * @param $directory
     * @return string
     */
    protected function getAddonClassNameFromDirectory($directory)
    {
        return "App\\Addons\\${directory}\\${directory}Addon";
    }

    /**
     * @return array
     */
    public function getClassMap()
    {
        return $this->classMap;
    }

    /**
     * @param array $classMap
     * @return $this
     */
    public function setClassMap($classMap)
    {
        $this->classMap = $classMap;

        return $this;
    }

    /**
     * @param $classNamespace
     * @param $storagePath
     */
    public function addClassMapping($classNamespace, $storagePath)
    {
        $this->classMap[$classNamespace] = $storagePath;
    }

    /**
     * @return array
     */
    public function getAddons()
    {
        return $this->addons;
    }

    /**
     * @return string
     */
    public function getAddonDirectory()
    {
        return $this->addonDirectory;
    }
}
