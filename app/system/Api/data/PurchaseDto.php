<?php
namespace app\repository\data;

use froq\app\data\InputInterface;
use froq\common\interface\Arrayable;

/**
 * Purchase DTO.
 * @data
 */
class PurchaseDto implements InputInterface, Arrayable {
    var ?string $device_uuid;
    var ?string $device_name;

    /**
     * Simple validation check.
     */
    function isValid(): bool {
        return !empty($this->device_uuid)
            && !empty($this->device_name);
    }

    /**
     * @inheritDoc
     */
    function toArray(): array {
        return [
            'device_uuid' => $this->device_uuid ?? null,
            'device_name' => $this->device_name ?? null,
        ];
    }
}
