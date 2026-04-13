<?php
require_once __DIR__ . "/../models/AdminManager.php";
require_once __DIR__ . "/Encryptor.php";

$adminManager = new AdminManager(); //On instancie le manager
$userIp = $_SERVER['REMOTE_ADDR']; // On récupère l'ip du visiteur
// On vérifie si l'ip du visiteur figure dans la blacklist, si oui on bloque l'accés
if ($adminManager->verifyToBlacklist($userIp)) {
  http_response_code(403);
  die("<h1 style='color:red;text-align:center;'>Accès Interdit</h1>
       <p style='text-align:center;'>Vous êtes bannie.</p>");
}
// On initialise la navigation autorisé
const AVAILABLE_ROUTES = [
  'guard' => 'ShieldController',
  'home' => 'HomeController',
  'administration' => 'AdminController',
  'tools' => 'ToolsController',
  'tips' => 'TipsController',
  'forum' => 'ForumController',
  'logout' => 'LogoutController',
];

//on récupère la page de guard (l'index) → le shield
$page = 'guard';
if (isset($_GET['page'])) {
  //si la page est vérifié on chiffre l'url
  $decrypted = Encryptor::decrypt($_GET['page']);
  //si la clé de tableau est éxistante on déchiffre
  if ($decrypted && array_key_exists($decrypted, AVAILABLE_ROUTES)) {
    $page = $decrypted;
  } else {
    // Si le token est invalide ou tentative de modification la signature HMAC sera déclaré corrompue
    http_response_code(403);
    die("<div style='position: fixed; top: 0; left: 0; display: flex; align-items: center; justify-content: center; height: 100vh; width: 100%; z-index: 999; background-color: #000;'>
    <p style='color: #fff; font-size: 4rem; text-align: center; letter-spacing: 2px;'>ERROR(403):URL corruption attempt you are blocked.</p>
    </div>");
  }
}
//si jamais la page n'existe pas dans une des clée du tableau indexé on redirige sur le shield automatiquement
if (!array_key_exists($page, AVAILABLE_ROUTES)) {
  $page = 'guard';
}

//on stocke les pages avec connexion requise (SESSION) dans un tableau
$protected_private_page = ['home', 'administration', 'logout', 'tools', 'tips', 'forum'];

//on verifie que la page demander par l'utilisateur figure biens dans le tableau de pages avec connexion requise
if (in_array($page, $protected_private_page)) {
  //si la session n'est pas vérifier on l'envoi sur la page de guard
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

  //on instancie et on appel la methode
  $app = new $controllerName();
  //structure conditionelle pour switché entre les pages
  if ($page === 'guard') {
    if (isset($_SESSION['auth_admin']) && $_SESSION['auth_admin'] === true) {
      $home_encrypted = Encryptor::encrypt('home');
      header("Location: index.php?page=" . $home_encrypted);
      exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $app->accessControll();
    } else {
      $_SESSION = [];
      session_destroy();
      session_start();
    }
    $app->insertionVisits();
    $app->guardPage();
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
