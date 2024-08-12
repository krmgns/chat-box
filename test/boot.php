<?php declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use froq\http\client\{Client, Response};

date_default_timezone_set('UTC');

/**
 * Base test case.
 */
abstract class TestCase extends PHPUnit\Framework\TestCase
{
    function request(
        string $method, string $path,
        array $body = null, array $headers = null
    ): Response {
        $client = new Client(
            url: 'http://localhost:8000/' . trim($path, '/'),
            options: ['json' => true, 'gzip' => false]
        );

        return $client->send($method, body: $body, headers: $headers);
    }
}
