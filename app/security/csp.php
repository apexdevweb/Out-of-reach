<?php
// Règles définies pour l'en-tête (Content-Security-Policy)
$csp = "default-src 'self'; ";

// Autorise les scripts locaux et le CDN
$csp .= "script-src 'self' https://cdn.jsdelivr.net 'unsafe-inline'; ";

// Styles (Google Fonts + CDN + Inline)
$csp .= "style-src 'self' https://fonts.googleapis.com https://cdn.jsdelivr.net 'unsafe-inline'; ";

// Polices
$csp .= "font-src 'self' https://fonts.gstatic.com; ";

// AJOUT DE blob: ICI (Indispensable pour que face-api affiche le scan)
$csp .= "img-src 'self' data: blob:; "; 

// IMPORTANT : Autorise la lecture des modèles JSON et les fichiers binaires de l'IA
$csp .= "connect-src 'self' https://cdn.jsdelivr.net; ";

// IMPORTANT : Autorise le flux vidéo de la webcam (blob:)
$csp .= "media-src 'self' blob:; ";


