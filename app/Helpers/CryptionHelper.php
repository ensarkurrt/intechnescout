<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CryptionHelper
{
    private static $salt_key;

    public function __construct()
    {
        self::$salt_key = Session::get('salt_key');
        Log::critical('salt_key: ' . self::$salt_key);
    }

    static function encode($text)
    {
        $encoded = base64_encode(openssl_encrypt($text, 'AES-128-ECB', (new self)::$salt_key));
        return $encoded;
    }

    static function decode($text)
    {
        return openssl_decrypt(base64_decode($text), 'AES-128-ECB', (new self)::$salt_key);
    }
}
