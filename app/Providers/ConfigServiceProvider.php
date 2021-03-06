<?php
/**
 * Author: Abel Halo <zxz054321@163.com>
 */

namespace App\Providers;

use App\Foundation\Config;
use Illuminate\Contracts\Config\Repository;
use Silex\Application;
use Silex\ServiceProviderInterface;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     * @param Application $app
     */
    public function register(Application $app)
    {
        $config = new Config();

        $this->loadConfigurationFiles($config);

        $env = ROOT.'/_';

        if (file_exists($env)) {
            /** @noinspection PhpIncludeInspection */
            $config->merge(require $env);
        }

        $app['debug']  = $config->get('app.debug', false);
        $app['config'] = $config;
    }

    /**
     * Load the configuration items from all of the files.
     *
     * @param  Repository $repository
     * @return void
     */
    protected function loadConfigurationFiles(Repository $repository)
    {
        foreach ($this->getConfigurationFiles() as $key => $path) {
            /** @noinspection PhpIncludeInspection */
            $repository->set($key, require $path);
        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @return array
     */
    protected function getConfigurationFiles()
    {
        $files = [];

        $configPath = realpath(CONFIG_PATH);

        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $nesting = $this->getConfigurationNesting($file, $configPath);

            /** @noinspection PhpUndefinedMethodInspection */
            $files[ $nesting.basename($file->getRealPath(), '.php') ] = $file->getRealPath();
        }

        return $files;
    }

    /**
     * Get the configuration file nesting path.
     * @param SplFileInfo $file
     * @param $configPath
     * @return string
     */
    protected function getConfigurationNesting(SplFileInfo $file, $configPath)
    {
        $directory = dirname($file->getRealPath());

        if ($tree = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $tree = str_replace(DIRECTORY_SEPARATOR, '.', $tree).'.';
        }

        return $tree;
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     * @param Application $app
     */
    public function boot(Application $app)
    {
    }
}