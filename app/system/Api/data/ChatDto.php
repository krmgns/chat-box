<?php
namespace app\repository\data;

use froq\app\data\InputInterface;
use froq\common\interface\Arrayable;

/**
 * Chat DTO.
 * @data
 */
class ChatDto implements InputInterface, Arrayable {
    var ?string $chat_id;
    var ?string $message;

    /**
     * Simple validation check.
     */
    function isValid(): bool {
        return !empty($this->message);
    }

    /**
     * @inheritDoc
     */
    function toArray(): array {
        return [
            'chat_id' => $this->chat_id ?? null,
            'message' => $this->message ?? null,
        ];
    }
}
