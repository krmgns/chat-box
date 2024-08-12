<?php declare(strict_types=1);
namespace app\repository\data;

use froq\database\entry\Entry;

/**
 * Subscription entry.
 * @data
 */
class Subscription extends Entry {
    /**
     * Find an subscription entry & fill its data.
     */
    function find(string $token): self {
        $this->query('subscription')
             ->select('*')
             ->where([
                'access_token' => $token
             ]);

        $this->commit();

        return $this;
    }

    /**
     * @override
     */
    function toArray(): array {
        return [
            'id'     => $this->id,
            'status' => $this->status,
            'credit' => $this->credit
        ];
    }
}
