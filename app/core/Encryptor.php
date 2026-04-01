<?php
class Encryptor
{
  private static $key = "77aa51799d148c13be0a86d3e66b33b7";
  private static $hmacKey = "b56b80ed367d041edb3e50d18e50035a";
  private static $cipher = "aes-256-cbc";

  public static function encrypt($data)
  {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$cipher));
    $encrypted = openssl_encrypt($data, self::$cipher, self::$key, OPENSSL_RAW_DATA, $iv);
    $payload = $iv . $encrypted;
    $hmac = hash_hmac('sha256', $payload, self::$hmacKey, true);
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($hmac . $payload));
  }

  public static function decrypt($token)
  {
    $decoded = base64_decode(str_replace(['-', '_'], ['+', '/'], $token));
    $hmacSize = 32;
    $payload = substr($decoded, $hmacSize);
    $receivedHmac = substr($decoded, 0, $hmacSize);
    $calculatedHmac = hash_hmac('sha256', $payload, self::$hmacKey, true);

    if (!hash_equals($receivedHmac, $calculatedHmac)) return false;

    $ivSize = openssl_cipher_iv_length(self::$cipher);
    $iv = substr($payload, 0, $ivSize);
    $encrypted = substr($payload, $ivSize);
    return openssl_decrypt($encrypted, self::$cipher, self::$key, OPENSSL_RAW_DATA, $iv);
  }
}
