<?php
Class Task{
   //Возможные статусы
   const STATUS_NEW="New";
   const STATUS_ABORTED="Aborted";
   const STATUS_IN_WORK="In work";
   const STATUS_COMPLETED="Completed";
   const STATUS_FAILED="Failed";
   //Возможные действия
   const ACTION_RESPONSE="Response";
   const ACTION_ABORT="Abort";
   const ACTION_FAILURE="Failure";
   const ACTION_COMPLETE="Complete";
   //свойства-идентификаторы
   private $clientId,$workerId;//убран blacklist, Client вместо User
   private $status=self::STATUS_NEW;
   //карты статуса -в качечтве ключа теперь константа
   //private $statusMap=["New"=>"Новая","Aborted"=>"Отменена","In work"=>"В работе","Completed"=>"Выполнено","Failed"=>"Не выполнено"];
    private $statusMap = [self::STATUS_NEW => "Новая", self::STATUS_ABORTED => "Отменена", self::STATUS_IN_WORK => "В работе", self::STATUS_COMPLETED => "Выполнено", self::STATUS_FAILED => "Не выполнено"];
   //карты действий-в качечтве ключа теперь константа
   //private $actionMap=["Response"=>"Откликнулись","Abort"=>"Отменить","Failure"=>"Отказаться","Complete"=>"Выполнить"];
    private $actionMap = [self::STATUS_NEW => "Откликнуться,Отменить", self::STATUS_ABORTED => "Отменено, нет доступных действий", self::STATUS_IN_WORK => "Отказаться,Выполнить", self::STATUS_COMPLETED => "Выполнено, нет доступных действий", self::STATUS_FAILED => "Отменить,Откликнуться"];
   /*private function __constructor($userId){
      $this->userId=$userId;
   }*/
    public function __construct($clientId,$workerId)
    {
        $this->clientId = $clientId;
        $this->workerId = $workerId;
    }//изменение конструктора
   //Доступные действия заказчика
    // Полностью переработал действия
    public function actions($action, $id)
    {
        //Доступные действия заказчика
        if ($id == $this->clientId) {
            switch ($action) {
                case self::ACTION_ABORT:
                    if ($this->status == self::STATUS_NEW) {
                        $this->status = self::STATUS_ABORTED;
                        return $this->status;
                    }else{return "Можно отменить только новое задание!";}
                case self::ACTION_COMPLETE:
                    if ($this->status == self::STATUS_IN_WORK) {
                        $this->status = self::STATUS_COMPLETED;
                        return $this->status;
                    }else{return "Задание не в работе!";}
                default:
                    return "Недоступная команда";
            }
        }
        //Доступные действия работника
        if ($id == $this->workerId) {
            switch ($action) {
                case self::ACTION_RESPONSE:
                    if ($this->status == self::STATUS_NEW || $this->status == self::STATUS_FAILED) {
                        $this->status = self::STATUS_IN_WORK;;
                        return $this->status;
                    }else{return "Исполнитель не требуется";}
                case self::ACTION_FAILURE:
                    if ($this->status == self::STATUS_IN_WORK) {
                        $this->status = self::STATUS_FAILED;
                        return $this->status;
                    }else{return "Нельзя отказаться";}
                default:
                    return "Недоступная команда";
            }
        }
    }

    public function actionMap (){
      return $this->actionMap[$this->status];
      //исправил карту действий
   }
   public function status (){
      return $this->statusMap[$this->status];
   }
}
?>
