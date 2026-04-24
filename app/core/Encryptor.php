<?php
class Encryptor
{
    // LA clé secrète doit faire 32 caractères pour l'AES-256
    private static $key = "77aa51799d148c13be0a86d3e66b33b7";
    private static $cipher = "aes-256-gcm";//AES-256 Galois-Counter-Mode
    public static function encrypt($data)
    {
        $ivSize = openssl_cipher_iv_length(self::$cipher);
        $iv = random_bytes($ivSize); // GCM recommande random_bytes au lieu de pseudo_bytes
        
        // Le tag est récupéré par référence
        $encrypted = openssl_encrypt($data, self::$cipher, self::$key, OPENSSL_RAW_DATA, $iv, $tag);
        
        // On stocke IV(Initialisation Vector) + TAG + DONNÉES
        // Le tag GCM fait par défaut 16 octets
        $payload = $iv . $tag . $encrypted;
        
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    }

    public static function decrypt($token)
    {
        $decoded = base64_decode(str_replace(['-', '_'], ['+', '/'], $token));
        
        $ivSize = openssl_cipher_iv_length(self::$cipher);
        $tagSize = 16; // Taille standard du tag GCM en PHP
        
        // Extraction des morceaux
        $iv = substr($decoded, 0, $ivSize);
        $tag = substr($decoded, $ivSize, $tagSize);
        $encrypted = substr($decoded, $ivSize + $tagSize);

        // Déchiffrement avec vérification automatique du tag
        $decrypted = openssl_decrypt($encrypted, self::$cipher, self::$key, OPENSSL_RAW_DATA, $iv, $tag);

        // Si le tag est invalide (donnée modifiée), openssl_decrypt renverra false
        return $decrypted;
    }
}
