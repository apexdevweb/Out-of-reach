<?php
class DataCrypting {
    private static $key = "votre_cle_de_32_caracteres_min!!"; // Clé AES
    private static $hmacKey = "votre_cle_de_signature_secrete"; // Clé HMAC
    private static $cipher = "aes-256-cbc";

    // CHIFFRER + SIGNER
    public static function encrypt($data) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$cipher));
        
        // 1. Chiffrement
        $encrypted = openssl_encrypt($data, self::$cipher, self::$key, OPENSSL_RAW_DATA, $iv);
        $payload = $iv . $encrypted;

        // 2. Signature (HMAC)
        $hmac = hash_hmac('sha256', $payload, self::$hmacKey, true);

        // 3. Assemblage final et encodage URL
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($hmac . $payload));
    }

    // VÉRIFIER SIGNATURE + DÉCHIFFRER
    public static function decrypt($token) {
        $decoded = base64_decode(str_replace(['-', '_'], ['+', '/'], $token));
        
        $hmacSize = 32; // SHA-256 fait 32 octets
        $ivSize = openssl_cipher_iv_length(self::$cipher);

        // Extraction
        $receivedHmac = substr($decoded, 0, $hmacSize);
        $payload = substr($decoded, $hmacSize);
        $iv = substr($payload, 0, $ivSize);
        $encrypted = substr($payload, $ivSize);

        // VÉRIFICATION DU SCEAU (HMAC)
        $calculatedHmac = hash_hmac('sha256', $payload, self::$hmacKey, true);
        
        if (!hash_equals($receivedHmac, $calculatedHmac)) {
            return false; // Alerte : L'URL a été modifiée !
        }

        // DÉCHIFFREMENT (seulement si le HMAC est valide)
        return openssl_decrypt($encrypted, self::$cipher, self::$key, OPENSSL_RAW_DATA, $iv);
    }
}
