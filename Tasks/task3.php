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
   private $userId,$workerId,$blackList=[];
   private $status=self::STATUS_NEW;
   //карты статуса
   private $statusMap=["New"=>"Новая","Aborted"=>"Отменена","In work"=>"В работе","Completed"=>"Выполнено","Failed"=>"Не выполнено"];
   //карты действий
   private $actionMap=["Response"=>"Откликнулись","Abort"=>"Отменить","Failure"=>"Отказаться","Complete"=>"Выполнить"];
   private function __constructor($userId){
      $this->userId=$userId;
   }
   //Доступные действия заказчика
   public function userActions ($action){
         if($this->status=="New" or $this->status=="Failed"){
            switch($action){
               case "Abort":if($this->status=="Failed" or $this->status=="New")$this->status=self::STATUS_ABORTED;
               break;
               case "Response":
               break;}
            }else if($this->status=="In work" and $action=="Complete"){$this->status=self::STATUS_COMPLETED;}
         }
   //Доступные действия работника
   public function workerActions ($action,$workerId){
      if($this->status=="New" or $this->status=="Failed"){
         switch($action){
            case "Response":$this->status=self::STATUS_IN_WORK;
               $this->workerId=$workerId;
            break;
            case "Failure": $this->status=self::STATUS_FAILED;
               array_push($this->workerId);
               $this->workerId=null;
               break;
         }
      }
   }
   public function actionMap ($actName){
      return $this->actionMap[$actName];
   }
   public function status (){
      return $this->statusMap[$this->status];
   }
}
?>