<?php
namespace app\library;

use froq\encrypting\Crypt;

/**
 * Token crypter class, provides encrypt/decrypt operations.
 */
class TokenCrypter {
    /**
     * Encrypt given token data as JSON.
     */
    static function encrypt(array $data): string {
        $crypt = new Crypt(app()->config('secret'), true);
        return $crypt->encrypt(json_serialize($data));
    }

    /**
     * Decrypt given token data as JSON.
     */
    static function decrypt(string $token): array {
        $crypt = new Crypt(app()->config('secret'), true);
        return json_unserialize($crypt->decrypt($token), true);
    }
}
