<?php

class ErrorProcess
{
  const ERRORS = array(
        301 => 'Moved permanently',
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal server error',
        502 => 'Bad gateway',
        503 => 'Service unavailable',
    );

  private $code;

  public function __construct($code = null)
  {
    $this->code = $code;
  }

  public function errorHandler($code)
  {
    try
      {
      if ($code != 200 && $code != 204) {
            throw new Exception(isset(self::ERRORS[$code]) ? self::ERRORS[$code] : 'Undescribed error', $code);
      }
      }
      catch (Exception $E) {
        die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
      }
  }
}
