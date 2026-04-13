<?php
class Administrator
{

  private int $admin_id;
  private string $admin_name;
  private string $admin_key;
  private string $admin_pin;

  public function __construct(int $adminId, string $adminName, string $adminKey, string $adminPin)
  {
    $this->admin_id = $adminId;
    $this->admin_name = $adminName;
    $this->admin_key = $adminKey;
    $this->admin_pin = $adminPin;
  }
  public function getAdminId(): int
  {
    return $this->admin_id;
  }
  public function getAdminName(): string
  {
    return $this->admin_name;
  }
  public function getAdminKey(): string
  {
    return $this->admin_key;
  }
  public function getAdminPin(): string
  {
    return $this->admin_pin;
  }
}
