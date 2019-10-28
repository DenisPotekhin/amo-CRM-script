<?php

class Task
{
  private $elementId;
  private $elementType = 2;
  private $taskType = 1;
  private $text;
  private $responsibleUserId = 109999;
  private $completeTillAt = 1975285346;

  public function __construct($elementId = null)
  {
    $this->elementId = $elementId;
  }

  public function setElementId($elementId)
  {
    $this->elementId = $elementId;
  }

  public function setElementType($elementType)
  {
    $this->elementType = $elementType;
  }

  public function setTaskType($taskType)
  {
    $this->taskType = $taskType;
  }

  public function setText($text)
  {
    $this->text = $text;
  }

  public function setResponsibleUserId($responsibleUserId)
  {
    $this->responsibleUserId = $responsibleUserId;
  }

  public function setСompleteTillAt($completeTillAt)
  {
    $this->completeTillAt = $completeTillAt;
  }

  public function taskToJson()
  {
    $taskToArray['add'] = array(
                array(
                    'element_id' => $this->elementId, #ID сделки
                    'element_type' => $this->elementType,
                    'task_type' => $this->taskType,
                    'text' => $this->text,
                    'responsible_user_id' => $this->responsibleUserId,
                    'complete_till_at' => $this->completeTillAt,
                ),
            );
    return json_encode($taskToArray);
  }
}

