<?php
const AVAILABLE_ROUTES = [
  'guard' => 'ShieldController',
  'home' => 'HomeController',
  'administration' => 'AdminController',
  'users' => 'UsersController',
  'logout' => 'LogoutController',
];
//on récupère la page
if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 'guard';
}
//si jamais la page n'existe pas dans une des clée du tableau indexé on redirige sur 'home' automatiquement
if (!array_key_exists($page, AVAILABLE_ROUTES)) {
  $page = 'guard';
}

//on stocke les pages avec connexion requise (SESSION) dans un tableau
$protected_private_page = ['home', 'administration', 'logout'];

//on verifie que la page demander par l'utilisateur figure biens dans le tableau de pages avec connexion requise
if (in_array($page, $protected_private_page)) {
  //si la session n'est pas vérifier on l'envoi sur la page login
  if (!isset($_SESSION['auth_admin']) && !isset($_SESSION['admin_data']['admin_key'])) {
    header("Location: index.php?page=guard");
    exit();
  }
}

//on charge le fichier controller en placant le chemin dans des variables
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['try_access'])) {
      $app->accessControll();
    }
    $app->guardPage();
  } elseif ($page === 'home') {
    $app->homePage();
  } elseif ($page === 'administration') {
    $app->adminPage();
  } elseif ($page === 'logout') {
    $app->logoutPage();
  }
} else {
  echo "Controleur introuvable";
}
