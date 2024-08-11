<?php
namespace app\controller;

use froq\AppException;
use froq\app\Controller;
use froq\http\HttpException;
use froq\http\response\{Status, payload\JsonPayload};
use froq\http\exception\client\{NotFoundException, NotAllowedException};

/**
 * App controller.
 * @call /*
 */
class AppController extends Controller {
    /**
     * Index.
     * @call * /api
     */
    function index(): JsonPayload {
        return $this->send(
            Status::NOT_FOUND,
            error: 'Not found'
        );
    }

    /**
     * Error handler.
     * @call N/A
     */
    function error($e = null): JsonPayload {
        $status = Status::INTERNAL_SERVER_ERROR;
        $message = null;

        if ($e instanceof AppException) {
            $cause = $e->getCause();
            switch (true) {
                case ($cause instanceof NotFoundException):
                    $status = $e->getCode();
                    $message = sprintf(
                        'No route found: %s %s',
                        $this->request->getMethod(),
                        chop($this->request->getPath(), '/'),
                    );
                    break;
                case ($cause instanceof NotAllowedException):
                    $status = $e->getCode();
                    $message = sprintf(
                        'No method allowed: %s %s',
                        $this->request->getMethod(),
                        chop($this->request->getPath(), '/'),
                    );
                    break;
                default:
                    $code = $e->getCode();
                    if ($code && Status::validate($code)) {
                        $status = $code;
                        $message = Status::getTextByCode($code);
                    }
            }
        }

        return $this->send($status, error: $message);
    }

    /**
     * To send a standart JSON payload with "status", "data" and "error" fields.
     * @internal
     */
    protected function send(int $status, array $data = null, mixed $error = null): JsonPayload {
        return new JsonPayload($status, [
            'status' => $status,
            'data'   => $data,
            'error'  => $error
        ]);
    }
}
