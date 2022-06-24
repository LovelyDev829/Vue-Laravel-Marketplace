<?php

namespace App\LaravelAddons;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;

abstract class Addon
{
    protected $app;

    /**
     * The Addon Name.
     *
     * @var string
     */
    public $name;

    /**
     * A description of the addon.
     * 
     * @var string
     */
    public $description;

    /**
     * The version of the addon.
     * 
     * @var string
     */
    public $version;

    /**
     * @var $this
     */
    private $reflector = null;

    /**
     * Addon constructor.
     *
     * @param $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->checkAddonName();
    }

    abstract public function boot();

    /**
     * Check for empty addon name.
     *
     * @throws \InvalidArgumentException
     */
    private function checkAddonName()
    {
        if (!$this->name) {
            throw new \InvalidArgumentException('Missing Addon name.');
        }
    }

    /**
     * Returns the view namespace in a camel case format based off
     * the addons class name, with addon stripped off the end.
     * 
     * Eg: ArticlesAddon will be accessible through 'addon:articles::<view name>'
     *
     * @return string
     */
    protected function getViewNamespace()
    {
        return 'addon:' . Str::camel(
            mb_substr(
                get_called_class(),
                strrpos(get_called_class(), '\\') + 1,
                -5
            )
        );
    }

    /**
     * Add a view namespace for this addon.
     * Eg: view("addon:articles::{view_name}")
     *
     * @param string $path
     */
    protected function enableViews($path = 'views')
    {
        $this->app['view']->addNamespace(
            $this->getViewNamespace(),
            $this->getAddonPath() . DIRECTORY_SEPARATOR . $path
        );
    }

    /**
     * @return string
     */
    public function getAddonPath()
    {
        $reflector = $this->getReflector();
        $fileName  = $reflector->getFileName();

        return dirname($fileName);
    }

    /**
     * @return string
     */
    protected function getAddonControllerNamespace()
    {
        $reflector = $this->getReflector();
        $baseDir   = str_replace($reflector->getShortName(), '', $reflector->getName());

        return $baseDir . 'Http\\Controllers';
    }

    /**
     * @return \ReflectionClass
     */
    private function getReflector()
    {
        if (is_null($this->reflector)) {
            $this->reflector = new \ReflectionClass($this);
        }

        return $this->reflector;
    }

    /**
     * Returns a addon view
     *
     * @param $view
     * @return \Illuminate\View\View
     */
    protected function view($view)
    {
        return view($this->getViewNamespace() . '::' . $view);
    }
}
