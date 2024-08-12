<?php

return [
    /* Note: dot (.) notations are valid for base keys. */
    /* With/without dots. */
    /* 'response' => ['json' => ['flags' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE]] */
    /* 'response.json' => ['flags' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE] */

    /* Routes & services. */
    'routes'   => require __DIR__ . '/routes.php',
    'services' => require __DIR__ . '/services.php',

    /* Protocols. */
    'http'     => 'http://' . $_SERVER['SERVER_NAME'],
    'https'    => 'https://' . $_SERVER['SERVER_NAME'],

    /* Localization. */
    'timezone' => 'UTC',
    'language' => 'en',
    'encoding' => 'UTF-8',
    'locales'  => [LC_TIME => 'en_US.UTF-8'],

    /* Ini. */
    // 'ini' => [string => scalar],

    /* Initial response headers (null means remove). */
    'headers'  => [
        // Cache (https://stackoverflow.com/questions/49547/how-do-we-control-web-page-caching-across-all-browsers).
        'Cache-Control'          => 'no-cache, no-store, must-revalidate, max-age=0, pre-check=0, post-check=0',
        'Pragma'                 => 'no-cache',
        'Expires'                => '0',
        // 'Connection'             => 'close',
        'X-Powered-By'           => 'Froq!',
        // Security (https://www.owasp.org/index.php/List_of_useful_HTTP_headers).
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options'        => 'sameorigin',
        'X-XSS-Protection'       => '1; mode=block',
    ],

    /* Initial response cookies. */
    // 'cookies'  => [name => [value, ?[options]]],

    /* Logger options. */
    // 'logger' => [
    //     'level'     => froq\log\LogLevel::ERROR | froq\log\LogLevel::WARN,
    //     'directory' => APP_DIR . '/var/log',
    // ],

    /* Session options (true = activate with default options). */
    // 'session'  => true,
    /* With custom options (below is default). */
    // 'session'  => [
    //     'name'     => 'SID',
    //     'hash'     => 'uuid' or 32, 40, 16, 'hashUpper' => bool,
    //     'savePath' => null, 'saveHandler' => class or [class, class-file],
    //     'cookie'   => [
    //         'lifetime' => 0,    'path'     => '/',  'domain'   => '',
    //         'secure'   => bool, 'httponly' => bool, 'samesite' => '',
    //     ],
    // ],

    /* Response options. */
    // 'response.compress'       => ['gzip' or 'zlib', 'minlen' => 64 (in kb) 'level' => 1..9],
    // 'response.xml'            => ['indent' => bool, 'indentString' => ' '],
    // 'response.json'           => ['indent' => string|int, 'flags' => JSON_*],
    // 'response.file.rateLimit' => 1024 ** 2, // 1MB

    /* As this is a sample, we want to see indented JSON strings */
    'response.json' => ['indent' => 2],

    /* Database options. */
    // 'database'    => [
    //     'dsn'  => string,
    //     'user' => string, 'pass' => string,
    //     'profiling' => bool, 'logging' => array // @see 'logger' options,
    // ],

    /* As this is a sample, we want to work with SQLite database. */
    'database' => ['dsn' => 'sqlite:' . APP_DIR . '/var/sample.db'],

    /* Cache options. */
    // 'cache' => ['id' => string, 'options' => ['id' => ?string, 'agent' => string, 'static' => bool,
    //     'ttl' => int, ...]],

    /* Router options. */
    // 'router' => ['defaultController' => string, 'defaultAction' => string,
    //              'unicode' => bool, 'decodeUri' => bool, 'endingSlashes' => bool],

    'router' => ['defaultController' => 'app\controller\AppController'],

    /* Dot-env. */
    // 'dotenv' => ['file' => string, 'global' => bool],

    /* View options. */
    // 'view' => ['base' => string, 'layout' => string],

    /* Misc options. */
    'exposeAppRuntime' => true, // true=all, false=none or 'development', 'testing', 'staging', 'production'

    // For token enc/dec.
    'secret' => '32JRbc8mZvk9x189P0e2VcxwmaAwPyE2vJQ9AoLbavKMZ7cAbczET41C',
];
