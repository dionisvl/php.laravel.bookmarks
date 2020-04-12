<?php


namespace App\Helpers;


class Security
{
    /**
     * Генерация хеш-кода на основе ключа, используя метод HMAC
     *
     * @param string $pass
     * @return string
     */
    public static function hmac(string $pass = ''): string
    {
        return $pass ? hash_hmac(env('HASH_ALGO'), $pass, env('HASH_KEY')) : '';
    }

}
