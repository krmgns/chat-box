<?php
namespace app\repository\data;

use froq\http\request\params\Params;

/**
 * Device params.
 * @data
 */
class Device {
    var string $uuid;
    var string $name;

    /**
     * Create a Device instance using post data,
     * and set properties as null-safe.
     */
    function __construct() {
        $params = new Params($_POST);

        $this->uuid = $params->getString('device_uuid');
        $this->name = $params->getString('device_name');
    }

    /**
     * Get device UUID.
     */
    function getUuid(): string {
        return $this->uuid;
    }

    /**
     * Get device name.
     */
    function getName(): string {
        return $this->name;
    }
}
