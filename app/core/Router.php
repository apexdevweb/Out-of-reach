<?php
require_once __DIR__ . "/../models/AdminManager.php";
require_once __DIR__ . "/Encryptor.php";

$adminManager = new AdminManager();
$userIp = $_SERVER['REMOTE_ADDR'];

if ($adminManager->verifyToBlacklist($userIp)) {
  http_response_code(403);
  die("<h1 style='color:red;text-align:center;'>Accès Interdit</h1>
       <p style='text-align:center;'>Vous êtes bannie.</p>");
}

const AVAILABLE_ROUTES = [
  'guard' => 'ShieldController',
  'home' => 'HomeController',
  'administration' => 'AdminController',
  'tools' => 'ToolsController',
  'tips' => 'TipsController',
  'forum' => 'ForumController',
  'logout' => 'LogoutController',
];

//on récupère la page
$page = 'guard';
if (isset($_GET['page'])) {
  $decrypted = Encryptor::decrypt($_GET['page']);

  if ($decrypted && array_key_exists($decrypted, AVAILABLE_ROUTES)) {
    $page = $decrypted;
  } else {
    // Si le token est invalide ou modifié (HMAC invalide)
    http_response_code(403);
    die("Erreur de sécurité : URL corrompue.");
  }
}
//si jamais la page n'existe pas dans une des clée du tableau indexé on redirige sur 'home' automatiquement
if (!array_key_exists($page, AVAILABLE_ROUTES)) {
  $page = 'guard';
}

//on stocke les pages avec connexion requise (SESSION) dans un tableau
$protected_private_page = ['home', 'administration', 'logout', 'tools', 'tips', 'forum'];

//on verifie que la page demander par l'utilisateur figure biens dans le tableau de pages avec connexion requise
if (in_array($page, $protected_private_page)) {
  //si la session n'est pas vérifier on l'envoi sur la page login
  if (!isset($_SESSION['auth_admin']) && !isset($_SESSION['admin_data']['admin_key'])) {
    // Pour la redirection, on chiffre aussi le lien vers 'guard'
    $guard_Encrypted = Encryptor::encrypt('guard');
    header("Location: index.php?page=" . $guard_Encrypted);
    exit();
  }
}

//on charge le fichier controller en placant le chemin dans une variable
$controllerName = AVAILABLE_ROUTES[$page];
$controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

//on vérifie que le fichier est existant
if (file_exists($controllerFile)) {
  //si le fichier existe on l'importe
  require_once $controllerFile;

  //on instancie et on appel la method
  $app = new $controllerName();
  //structure conditionelle pour switché entre les pages
  if ($page === 'guard') {
    if (session_status() === PHP_SESSION_ACTIVE) {
      session_unset();
    };
    $app->insertionVisits();
    $app->guardPage();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['try_access'])) {
      $app->accessControll();
    }
  } elseif ($page === 'home') {
    $app->homePage();
  } elseif ($page === 'administration') {
    $app->adminPage();
  } elseif ($page === 'logout') {
    $app->logoutPage();
  } elseif ($page === 'tools') {
    $app->toolsPage();
  } elseif ($page === 'tips') {
    $app->tipsPage();
  } elseif ($page === 'forum') {
    $app->forumPage();
  }
} else {
  echo "Controleur introuvable";
}
