<?php
class User
{
  private int $user_id;
  private string $user_mail;
  private string $user_name;
  private string $user_secure_key;

  public function __construct(int $userId, string $userMail, string $userName, string $userSecureKey)
  {
    $this->user_id = $userId;
    $this->user_mail = $userMail;
    $this->user_name = $userName;
    $this->user_secure_key = $userSecureKey;
  }
  public function getUserId(): int
  {
    return $this->user_id;
  }
  public function getUserMain(): string
  {
    return $this->user_mail;
  }
  public function getUserName(): string
  {
    return $this->user_name;
  }
  public function getUserKey(): string
  {
    return $this->user_secure_key;
  }
}
