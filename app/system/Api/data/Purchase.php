<?php declare(strict_types=1);
namespace app\repository\data;

use froq\database\entry\Entry;
use DateTime, DateTimeZone;

/**
 * Purchase entry.
 * @data
 */
class Purchase extends Entry {
    const STATUS = 'premium';
    const CREDIT = 100;

    /**
     * @override
     */
    function __construct(PurchaseDto $purchase = null) {
        parent::__construct($purchase?->toArray());
    }

    /**
     * Find a purchase & fill its data using the found row.
     *
     * Note: Since no RETURNING support for version < 3.35 in SQLite,
     * calling this method (SELECT) in others back to fill all data fields.
     */
    function find(int $id): self {
        $this->query('subscription')
             ->select('*')
             ->equal('id', $id);

        $this->reset();
        $this->commit();

        return $this;
    }

    /**
     * Save a purchase entry & fill its data.
     */
    function save(string $token): self {
        $date = new DateTime('', new DateTimeZone('UTC'));

        $this->query('subscription')->insert([
            'device_uuid'  => $this->device_uuid,
            'device_name'  => $this->device_name,
            'access_token' => $token,
            'status'       => self::STATUS,
            'credit'       => self::CREDIT,
            'created_at'   => $date,
            'updated_at'   => null
        ]);

        $this->commit();

        // Use insert id to fill the data.
        $this->find($this->result()->id() ?? 0);

        return $this;
    }
}
