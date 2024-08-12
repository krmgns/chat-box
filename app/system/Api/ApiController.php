<?php declare(strict_types=1);
namespace app\controller;

use froq\http\response\Status;
use froq\http\response\payload\JsonPayload;
use app\repository\data\{Device, PurchaseDto, ChatDto};
use app\library\{TokenCrypter, ChatResponder};

/**
 * API controller.
 * @call /api/*
 */
class ApiController extends AppController {
    /**
     * Target is ApiRepository.
     */
    var bool $useRepository = true;

    /**
     * @call POST /api/auth
     */
    function authAction(Device $device): JsonPayload {
        $data = $this->repository->findAuth($device);

        return $this->send(
            $data ? Status::OK : Status::NOT_FOUND,
            data: $data
        );
    }

    /**
     * @call POST /api/purchase
     */
    function purchaseAction(PurchaseDto $purchase): JsonPayload {
        // Data check.
        if (!$purchase->isValid()) {
            return $this->send(
                Status::BAD_REQUEST,
                error: 'Fields device_uuid & device_name required',
            );
        }

        $token = TokenCrypter::encrypt($purchase->toArray());
        $data = $this->repository->savePurchase($purchase, $token);

        return $this->send(
            $data ? Status::OK : Status::INTERNAL,
            data: $data
        );
    }

    /**
     * @call POST /api/subscription
     */
    function subscriptionAction(): JsonPayload {
        // Token check.
        if (!$token = $this->getAuthToken()) {
            return $this->send(
                Status::BAD_REQUEST,
                error: 'Invalid token'
            );
        }

        $data = $this->repository->findSubscription($token);

        return $this->send(
            $data ? Status::OK : Status::NOT_FOUND,
            data: $data
        );
    }

    /**
     * @call POST /api/chat
     */
    function chatAction(ChatDto $chat): JsonPayload {
        // Data check.
        if (!$chat->isValid()) {
            return $this->send(
                Status::BAD_REQUEST,
                error: 'Field message required',
            );
        }

        // Token check.
        if (!$token = $this->getAuthToken()) {
            return $this->send(
                Status::BAD_REQUEST,
                error: 'Invalid token'
            );
        }

        $subscription = $this->repository->findSubscription($token);

        // Subscription check.
        if (!$subscription) {
            return $this->send(
                Status::UNAUTHORIZED,
                error: 'Invalid subscription'
            );
        }
        // Subscription credit check.
        if ($subscription['credit'] < 1) {
            return $this->send(
                Status::PAYMENT_REQUIRED,
                error: 'Invalid subscription credit'
            );
        }

        $response = ChatResponder::respond(); // A random phrase.
        $data = $this->repository->saveChat($chat, $response, $subscription);

        return $this->send(
            $data ? Status::OK : Status::INTERNAL,
            data: [
                'id' => $data['id'],
                'pid' => $data['pid'],
                'response' => $response,
                'subscription' => $data['subscription'], // In case it's needed.
            ]
        );
    }

    /**
     * Get token data from Authorization header.
     * @internal
     */
    private function getAuthToken(): ?string {
        $auth = $this->request->header('Authorization');
        return $auth ? str_unprefix($auth, 'Bearer ') : null;
    }
}
