<?php
// Règles définies pour l'en-tête (Content-Security-Policy)
$csp = "default-src 'self'; ";
// Autorise les scripts locaux et le CDN
$csp .= "script-src 'self' https://cdn.jsdelivr.net 'unsafe-line'; ";
// AJOUT de 'unsafe-inline' pour permettre à Chart.js d'appliquer ses styles dynamiques
$csp .= "style-src 'self' https://fonts.googleapis.com https://cdn.jsdelivr.net 'unsafe-inline'; ";
$csp .= "font-src 'self' https://fonts.gstatic.com; ";
$csp .= "img-src 'self' data:; ";
