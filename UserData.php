<?php

class UserData
{
  private $userLogin;
  private $userHash;
  private $userSubDomain;

  private function subDomainFindMethod()
  {
    return substr($this->userLogin, 0, strpos($this->userLogin, '@'));
  }

  public function __construct($userLogin, $userHash)
  {
    $this->userLogin = $userLogin;
    $this->userHash = $userHash;
    $this->userSubDomain = $this->subDomainFindMethod();
  }

  public function getUserLogin()
  {
    return $this->userLogin;
  }

  public function getUserHash()
  {
    return $this->userHash;
  }

  public function getUserSubDomain()
  {
    return $this->userSubDomain;
  }

  public function userToJson()
  {
    $userToArray = array(
        'USER_LOGIN' => $this->userLogin,
        'USER_HASH' => $this->userHash,
    );
    return json_encode($userToArray);
  }
}

