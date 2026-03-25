<?php

class SecureAdminKey
{
  private string $secure_admin_key;

  public function __construct(string $admin_key)
  {
    $this->secure_admin_key = $admin_key;
  }
  public function getSecureKey(): string
  {
    return $this->secure_admin_key;
  }
  public function adminKeyVerify(string $user_input): bool
  {
      return hash_equals($this->secure_admin_key, $user_input);
  }
}