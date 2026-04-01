<?php
class LogoutController
{
  public function logoutPage()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    session_destroy();
    $logout_Encrypted = Encryptor::encrypt('guard');
    header("Location: index.php?page=" . $logout_Encrypted);
    exit();
  }
}
