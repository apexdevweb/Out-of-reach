<?php
class SecureAdminPin
{
  private string $secure_admin_pin;

  public function __construct(string $secureAdminPin)
  {
    $this->secure_admin_pin = $secureAdminPin;
  }
  public function getAdminPin(): string
  {
    return $this->secure_admin_pin;
  }
  public function adminPinVerify(string $user_pin_input): bool
  {
    $user_pin_input = trim($user_pin_input);
    if (strlen($user_pin_input) !== 8 || !ctype_digit($user_pin_input)) {
      return false;
    }
    return hash_equals($this->secure_admin_pin, $user_pin_input);
  }
}
