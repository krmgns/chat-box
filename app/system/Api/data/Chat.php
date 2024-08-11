<?php
namespace app\repository\data;

use froq\database\entry\Entry;
use DateTime, DateTimeZone;

/**
 * Chat entry.
 * @data
 */
class Chat extends Entry {
    const STATUS = 'premium';
    const CREDIT = 100;

    /**
     * @override
     */
    function __construct(ChatDto $chat = null) {
        parent::__construct($chat?->toArray());
    }

    /**
     * Find a chat & fill its data using the found row.
     *
     * Note: Since no RETURNING support for version < 3.35 in SQLite,
     * calling this method (SELECT) in others back to fill all data fields.
     */
    function find(int $id): self {
        $this->query('chat')
             ->select('*')
             ->equal('id', $id);

        $this->reset();
        $this->commit();

        return $this;
    }

    /**
     * Save a chat entry & fill its data & decrease subscription credit.
     */
    function save(string $response, array $subscription): self {
        $date = new DateTime('', new DateTimeZone('UTC'));

        $this->query('chat')->insert([
            'pid'        => $this->chat_id,
            'sid'        => $subscription['id'],
            'message'    => $this->message,
            'response'   => $response,
            'created_at' => $date,
            'updated_at' => null
        ]);

        $this->commit();

        // Use insert id to fill the data.
        $this->find($this->result()->id() ?? 0);

        // Update credit & related data.
        if ($this->okay()) {
            $subscription = new Subscription($subscription);
            $subscription->query('subscription')
                ->update(['credit' => $subscription->credit - 1])
                ->equal('id', $subscription->id);

            $subscription->commit();

            $this->subscription = [
                'id'     => $subscription->id,
                'status' => $subscription->status,
                'credit' => $subscription->credit - 1
            ];
        }

        return $this;
    }
}
