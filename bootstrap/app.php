<?php
/**
 * Author: Abel Halo <zxz054321@163.com>
 */

use App\Foundation\Application;
use App\Providers\AppServiceProvider;
use Monolog\Logger;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Ziadoz\Silex\Provider\CapsuleServiceProvider;

$app   = new Application();
$debug = config('app.debug');

$app->register(new MonologServiceProvider(), [
    'monolog.level'   => $debug ? Logger::WARNING : Logger::ERROR,
    'monolog.logfile' => STORAGE_PATH.'/logs/app.log',
]);

$app->register(new SessionServiceProvider());

$app->register(new UrlGeneratorServiceProvider());

$app->register(new TwigServiceProvider(), [
    'twig.path'    => VIEW_PATH,
    'twig.options' => [
        'debug'            => $debug,
        'cache'            => $debug ? false : STORAGE_PATH.'/framework/views',
        'optimizations'    => $debug ? 0 : -1,

        /*
         * If set to false, Twig will silently ignore invalid variables
         * (variables and or attributes/methods that do not exist) and
         * replace them with a null value. When set to true,
         * Twig throws an exception instead (default to false).
         */
        'strict_variables' => true,
    ],
]);

$app->register(new CapsuleServiceProvider, [
    'capsule.connection' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'database',
        'username'  => 'username',
        'password'  => 'password',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
        'logging'   => false,
    ],
]);

$app->register(new AppServiceProvider());