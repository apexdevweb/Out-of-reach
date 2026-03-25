<?php
//Règles définies pour l'en-tête →(Content-Security-Policy)
$csp = "default-src 'self';";
$csp .= "script-src 'self' https://cdn.jsdelivr.net; ";
$csp .= "style-src 'self' https://fonts.googleapis.com https://cdn.jsdelivr.net; ";
$csp .= "font-src 'self' https://fonts.gstatic.com; ";
$csp .= "img-src 'self' data:; ";
