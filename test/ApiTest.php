<?php
use froq\http\response\Status;

class ApiTest extends TestCase
{
    function test_purchase_okay() {
        $response = $this->request('POST', '/api/purchase', [
            'device_uuid' => '66b8baa6-7405-4d42-b950-ac2a39cf7196',
            'device_name' => 'Android'
        ]);
        $payload = $response->getParsedBody();

        self::assertSame(Status::OK, $response->getStatus());
        self::assertSame(Status::OK, $payload['status']);

        self::assertNotNull($payload['data']);
        self::assertNull($payload['error']);

        self::assertIsString($payload['data']['device_uuid']);
        self::assertIsString($payload['data']['device_name']);
        self::assertIsString($payload['data']['access_token']);

        self::assertSame('premium', $payload['data']['status']);
        self::assertSame(100, $payload['data']['credit']);
    }

    function test_purchase_bad_request() {
        $response = $this->request('POST', '/api/purchase', []);
        $payload = $response->getParsedBody();

        self::assertSame(Status::BAD_REQUEST, $response->getStatus());
        self::assertSame(Status::BAD_REQUEST, $payload['status']);

        self::assertNull($payload['data']);
        self::assertNotNull($payload['error']);
    }

    function test_auth_okay() {
        $response = $this->request('POST', '/api/auth', [
            'device_uuid' => '66b8baa6-7405-4d42-b950-ac2a39cf7196',
            'device_name' => 'Android'
        ]);
        $payload = $response->getParsedBody();

        self::assertSame(Status::OK, $response->getStatus());
        self::assertSame(Status::OK, $payload['status']);

        self::assertNotNull($payload['data']);
        self::assertNull($payload['error']);

        self::assertIsString($payload['data']['device_uuid']);
        self::assertIsString($payload['data']['device_name']);
        self::assertIsString($payload['data']['access_token']);

        self::assertSame('premium', $payload['data']['status']);
        self::assertIsInt($payload['data']['credit']);
    }

    function test_auth_not_found() {
        $response = $this->request('POST', '/api/auth', [
            'device_uuid' => '123',
            'device_name' => ''
        ]);
        $payload = $response->getParsedBody();

        self::assertSame(Status::NOT_FOUND, $response->getStatus());
        self::assertSame(Status::NOT_FOUND, $payload['status']);

        self::assertNull($payload['data']);
        self::assertNull($payload['error']);
    }

    function test_subscription_okay() {
        $response = $this->request('POST', '/api/subscription', [], [
            'Authorization' => '5UZF1ATg2tY0HsE0DFhCS9yptlBBHS4bxri8yWrPY6fVkXDOhrWMIwDHVIGX7QzwOg6ZWCdDISobkPqny3wPRSBepDYuBCeRzhMwogYZGHxIlhslWcFfszeeKRlAVYYs1P4Qm4NGAovE'
        ]);
        $payload = $response->getParsedBody();

        self::assertSame(Status::OK, $response->getStatus());
        self::assertSame(Status::OK, $payload['status']);

        self::assertNotNull($payload['data']);
        self::assertNull($payload['error']);

        self::assertIsInt($payload['data']['id']);
        self::assertIsInt($payload['data']['credit']);
        self::assertSame('premium', $payload['data']['status']);
    }

    function test_subscription_bad_request() {
        $response = $this->request('POST', '/api/subscription', [], [
            'Authorization' => ''
        ]);
        $payload = $response->getParsedBody();

        self::assertSame(Status::BAD_REQUEST, $response->getStatus());
        self::assertSame(Status::BAD_REQUEST, $payload['status']);

        self::assertNull($payload['data']);
        self::assertNotNull($payload['error']);
    }

    function test_subscription_not_found() {
        $response = $this->request('POST', '/api/subscription', [], [
            'Authorization' => '123'
        ]);
        $payload = $response->getParsedBody();

        self::assertSame(Status::NOT_FOUND, $response->getStatus());
        self::assertSame(Status::NOT_FOUND, $payload['status']);

        self::assertNull($payload['data']);
        self::assertNull($payload['error']);
    }

    function test_chat_okay() {
        $response = $this->request('POST', '/api/chat', [
            'chat_id' => null,
            'message' => 'Test'
        ], [
            'Authorization' => '5UZF1ATg2tY0HsE0DFhCS9yptlBBHS4bxri8yWrPY6fVkXDOhrWMIwDHVIGX7QzwOg6ZWCdDISobkPqny3wPRSBepDYuBCeRzhMwogYZGHxIlhslWcFfszeeKRlAVYYs1P4Qm4NGAovE'
        ]);
        $payload = $response->getParsedBody();

        self::assertSame(Status::OK, $response->getStatus());
        self::assertSame(Status::OK, $payload['status']);

        self::assertNotNull($payload['data']);
        self::assertNull($payload['error']);

        self::assertIsInt($payload['data']['id']);
        self::assertNull($payload['data']['pid']);
        self::assertIsString($payload['data']['response']);
        self::assertIsInt($payload['data']['subscription']['id']);
        self::assertIsInt($payload['data']['subscription']['credit']);
        self::assertSame('premium', $payload['data']['subscription']['status']);
    }

    function test_chat_bad_request() {
        $response = $this->request('POST', '/api/chat', [
            'chat_id' => null,
            'message' => null
        ], [
            'Authorization' => '5UZF1ATg2tY0HsE0DFhCS9yptlBBHS4bxri8yWrPY6fVkXDOhrWMIwDHVIGX7QzwOg6ZWCdDISobkPqny3wPRSBepDYuBCeRzhMwogYZGHxIlhslWcFfszeeKRlAVYYs1P4Qm4NGAovE'
        ]);
        $payload = $response->getParsedBody();

        self::assertSame(Status::BAD_REQUEST, $response->getStatus());
        self::assertSame(Status::BAD_REQUEST, $payload['status']);

        self::assertNull($payload['data']);
        self::assertNotNull($payload['error']);
    }

    function test_chat_unauthorized() {
        $response = $this->request('POST', '/api/chat', [
            'chat_id' => null,
            'message' => 'Test'
        ], [
            'Authorization' => '123'
        ]);
        $payload = $response->getParsedBody();

        self::assertSame(Status::UNAUTHORIZED, $response->getStatus());
        self::assertSame(Status::UNAUTHORIZED, $payload['status']);

        self::assertNull($payload['data']);
        self::assertNotNull($payload['error']);
    }
}
