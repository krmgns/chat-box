<?php
namespace app\repository\data;

use froq\database\entry\Entry;

/**
 * Auth entry.
 * @data
 */
class Auth extends Entry {
    /**
     * Find an auth entry & fill its data.
     */
    function find(Device $device): self {
        $this->query('subscription')
             ->select('*')
             ->where([
                'device_uuid' => $device->getUuid(),
                'device_name' => $device->getName()
             ]);

        $this->commit();

        return $this;
    }

    /**
     * @override
     */
    function toArray(): array {
        return [
            'device_uuid'  => $this->device_uuid,
            'device_name'  => $this->device_name,
            'access_token' => $this->access_token,
            'status'       => $this->status,
            'credit'       => $this->credit
        ];
    }
}
