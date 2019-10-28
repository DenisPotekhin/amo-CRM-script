<?php

class CurlProcess
{
  const PROTOCOL_STR = 'https://';
  const AUTH_END_LINK = '.amocrm.ru/private/api/auth.php?type=json';
  const DEAL_END_LINK = '.amocrm.ru/api/v2/leads';
  const TASK_END_LINK = '.amocrm.ru/api/v2/tasks';

  private $Link;
  private $subDomain;
  private $requestCode;
  private $requestData;

  public function __construct($subDomain)
  {
    $this->subDomain = $subDomain;
  }

  public function getRequestCode()
  {
    return $this->requestCode;
  }

  public function getRequestData()
  {
    return $this->requestData;
  }

  public function curlHandler($typeMethod, $jsonData = null)
  {
    /*
    $typeMethod -
    0 - authorization
    1 - deal index
    2 - task add
    */
    if ($typeMethod == 0) {
      $this->link = self::PROTOCOL_STR . $this->subDomain . self::AUTH_END_LINK;
    } elseif ($typeMethod == 1) {
      $this->link = self::PROTOCOL_STR . $this->subDomain . self::DEAL_END_LINK;
    } elseif ($typeMethod == 2) {
      $this->link = self::PROTOCOL_STR . $this->subDomain . self::TASK_END_LINK;
    }
    $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $this->link);
    if ($typeMethod != 1) {
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    }
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $this->requestData = curl_exec($curl);
    $this->requestCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
  }
}

