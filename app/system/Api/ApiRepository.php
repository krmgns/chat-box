<?php declare(strict_types=1);
namespace app\repository;

use froq\app\Repository;
use app\repository\data\{
    Auth, Device, Subscription,
    Purchase, PurchaseDto,
    Chat, ChatDto,
};

/**
 * API repository.
 * @data
 */
class ApiRepository extends Repository {
    /**
     * Create tables (if not exists).
     */
    function init(): void {
        // $file = APP_DIR . '/var/sample.db';
        // file_exists($file) && file_remove($file);

        $this->db->execute(
            file_read(__DIR__ . '/data/schema/db.sql')
        );

        // $res = $this->db->query("SELECT * FROM sqlite_master WHERE type='table'");
        // prd($res,1);
    }

    /**
     * Find an auth entry.
     */
    function findAuth(Device $device): ?array {
        $entry = (new Auth())->find($device);

        return $entry->okay() ? $entry->toArray() : null;
    }

    /**
     * Find a subscription entry.
     */
    function findSubscription(string $token): ?array {
        $entry = (new Subscription())->find($token);

        return $entry->okay() ? $entry->toArray() : null;
    }

    /**
     * Save a purchase entry.
     */
    function savePurchase(PurchaseDto $purchase, string $token): ?array {
        $entry = (new Purchase($purchase))->save($token);

        return $entry->okay() ? $entry->toArray() : null;
    }

    /**
     * Save a chat entry.
     */
    function saveChat(ChatDto $chat, string $response, array $subscription): ?array {
        $entry = (new Chat($chat))->save($response, $subscription);

        return $entry->okay() ? $entry->toArray() : null;
    }
}
