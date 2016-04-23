<?php
/**
 * Author: Abel Halo <zxz054321@163.com>
 */

return [
    'mysql' => [
        'driver'    => 'mysql',
        'host'      => '127.0.0.1',
        'database'  => 'glass',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'prefix'    => '',
        'collation' => 'utf8_unicode_ci',
        'logging'   => false,
    ],

    'migrations' => [
        'users',
    ],
];