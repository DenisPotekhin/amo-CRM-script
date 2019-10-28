<?php

require_once('UserData.php');
require_once('ErrorProcess.php');
require_once('Task.php');
require_once('CurlProcess.php');

// использовал своего пользователя, которого сам создал
const USER_LOGIN = 'alphaprint30@gmail.com';
const USER_HASH = 'b405c72a37e7cf46d75a7ead4936827b87e41b53';
// имя новой задачи
const NAME_NEW_TASK = 'Сделка без задачи';
// данные для новой задачи
const ELEMENT_TYPE_TASK = 2; #Показываем, что это - сделка, а не контакт
const TYPE_TASK = 1; #Звонок
const TASK_RESPONSIBLE_USER_ID = 109999; # случайный пользователь, нет условия в задаче

$taskComplete = intval(date('U') + '7200'); # текущая дата + 2 часа

function addNewTask(CurlProcess &$curlObject, Task &$taskObject, ErrorProcess $errorObject, $dealList = null)
{
  if ($dealList === null) {
    return;
  }
  $result = '';
  foreach ($dealList as $value) {
    if ($value['closest_task_at'] == 0) {
      $taskObject->setElementId($value['id']);
      $curlObject->curlHandler(2, $taskObject->taskToJson());
      $errorObject->errorHandler($curlObject->getRequestCode());
      $result = $result . 'Сделка - "' . $value['name'] . '"' . "<br/>" . 'Добавлена задача: "' . NAME_NEW_TASK . '"' . "<br/>";
    }
  }
  return $result;
}

function resultToOut($str)
{
  print_r("Скрипт для добавления новой задачи, к сделкам без задач" . "<br/>");
  print_r($str);
}

// инициализируем пользователя
$User = new UserData(USER_LOGIN, USER_HASH);
// инициализируем Curl обработчик для запросов к API
$CurlProcess = new CurlProcess($User->getUserSubDomain());
// инициализируем обработчик ошибок
$ErrorHandler = new ErrorProcess();
// Запускаем авторизацию пользователя
$CurlProcess->curlHandler(0, $User->userToJson());
// Запускаем обработчик ошибок, для проверки результата авторизации
$ErrorHandler->errorHandler($CurlProcess->getRequestCode());
// Запускаем Curl для получения списка сделок данного пользователя
$CurlProcess->curlHandler(1);
// Запускаем обработчик ошибок, для проверки результата получения списка
$ErrorHandler->errorHandler($CurlProcess->getRequestCode());
// Сохраняем в массив полученный ответ-список сделок
$deals = json_decode($CurlProcess->getRequestData(), true);
$dealIndex = $deals['_embedded']['items'];
// Инициализируем новую задача для добавления к сделкам
$Task = new Task();
$Task->setElementType(ELEMENT_TYPE_TASK);
$Task->setTaskType(TYPE_TASK);
$Task->setText(NAME_NEW_TASK);
$Task->setResponsibleUserId(TASK_RESPONSIBLE_USER_ID);
$Task->setСompleteTillAt($taskComplete);
// Запускаем функцию для добавления новой задачи к сделкам без задач
// сохраняем вывод функции в переменную, для возможного вывода работы
$strResult = addNewTask($CurlProcess, $Task, $ErrorHandler, $dealIndex);
//  если нужен вывод результата работы функции то вызываем resultToOut
resultToOut($strResult);
