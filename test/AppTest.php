<?php declare(strict_types=1);
use froq\http\response\Status;

class AppTest extends TestCase
{
    function test_index() {
        $response = $this->request('GET', '/');
        $payload = $response->getParsedBody();

        self::assertSame(Status::NOT_FOUND, $response->getStatus());
        self::assertSame(Status::NOT_FOUND, $payload['status']);

        self::assertNull($payload['data']);
        self::assertNotNull($payload['error']);
    }
}
