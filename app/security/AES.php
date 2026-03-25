<?php
// Tes deux clés secrètes (32 octets pour l'AES, 32 octets pour le HMAC)
// Conseil : Utilise des clés différentes pour le chiffrement et la signature
$encryptionKey = "cle_secrete_chiffrement_32_char!";
$hmacKey       = "cle_secrete_signature_32_chars!!";

/**
 * Chiffre ET signe une URL
 */
function encryptAndSign($data, $encKey, $signKey)
{
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

  // 1. Chiffrement AES-256
  $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encKey, OPENSSL_RAW_DATA, $iv);
  $combined  = $iv . $encrypted;

  // 2. Création de la signature HMAC (SHA-256) sur le bloc chiffré
  $hmac = hash_hmac('sha256', $combined, $signKey, true);

  // On assemble tout : HMAC + IV + Données et on encode pour l'URL
  return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($hmac . $combined));
}

/**
 * Vérifie la signature ET déchiffre l'URL
 */
function verifyAndDecrypt($encodedData, $encKey, $signKey)
{
  $crypted = base64_decode(str_replace(['-', '_'], ['+', '/'], $encodedData));

  $hmacSize = 32; // Taille d'un hash SHA-256
  $ivSize   = openssl_cipher_iv_length('aes-256-cbc');

  // Extraction des morceaux
  $receivedHmac = substr($crypted, 0, $hmacSize);
  $combined     = substr($crypted, $hmacSize);
  $iv           = substr($combined, 0, $ivSize);
  $cipherText   = substr($combined, $ivSize);

  // 3. Vérification de l'intégrité (HMAC)
  $calculatedHmac = hash_hmac('sha256', $combined, $signKey, true);

  // Comparaison sécurisée contre les attaques temporelles
  if (!hash_equals($receivedHmac, $calculatedHmac)) {
    return false; // L'URL a été modifiée ou la clé est fausse !
  }

  // 4. Déchiffrement si le HMAC est valide
  return openssl_decrypt($cipherText, 'aes-256-cbc', $encKey, OPENSSL_RAW_DATA, $iv);
}

// --- TEST ---
$urlOriginelle = "https://monsite.com";
$urlProtegee   = encryptAndSign($urlOriginelle, $encryptionKey, $hmacKey);

echo "URL Chiffrée & Signée : " . $urlProtegee . "\n\n";

$resultat = verifyAndDecrypt($urlProtegee, $encryptionKey, $hmacKey);

if ($resultat) {
  echo "Succès ! Contenu : " . $resultat;
} else {
  echo "Alerte : URL corrompue ou tentative de piratage !";
}
