<?php
session_start([
  'cookie_httponly' => true,  // Interdit au JavaScript de lire le cookie (protection anti-XSS)
  'cookie_secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on', // Le cookie n'est envoyé que sur une connexion HTTPS (protection anti-MitM)
  'cookie_samesite' => 'Strict', // Empêche l'envoi du cookie depuis un site tiers
  'use_only_cookies' => 1 // Interdit de faire passer l'ID de session dans l'URL (très dangereux)
]);

