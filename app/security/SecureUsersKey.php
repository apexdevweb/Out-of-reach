<?php

class SecureUsersKey
{
  private string $secure_key;

  public function __construct(int $key_lenght = 16)
  {
    $this->secure_key = bin2hex(random_bytes($key_lenght));
  }
  public function getSecureKey(): string
  {
    return $this->secure_key;
  }
  public function usersVerify(string $user_input): bool
  {
      return hash_equals($this->secure_key, $user_input);
  }
}
