<?php

namespace Service;

class Task
{

    /**
     * @var array actions list
     */
    private $actions = [];

    // Возможные статусы
    const STATUS_NEW = "New";

    const STATUS_ABORTED = "Aborted";

    const STATUS_IN_WORK = "In work";

    const STATUS_COMPLETED = "Completed";

    const STATUS_FAILED = "Failed";

    /**
     * @var int
     */
    private $clientId;
    
    /**
     * @var int
     */
    private $workerId;

    /**
     * @var string
     */
    private $status = self::STATUS_NEW;

    private $statusMap = [
        self::STATUS_NEW => "Новая",
        self::STATUS_ABORTED => "Отменена",
        self::STATUS_IN_WORK => "В работе",
        self::STATUS_COMPLETED => "Выполнено",
        self::STATUS_FAILED => "Не выполнено"
    ];

    private $actionMap = [
        AbortAction::INNER_NAME => AbortAction::READABLE_NAME,
        ResponseAction::ACTION_RESPONSE => ResponseAction::ACTION_RESPONSE_READABLE,
        CompleteAction::ACTION_COMPLETE => CompleteAction::ACTION_COMPLETE_READABLE,
        FailAction::ACTION_FAILURE => FailAction::ACTION_FAILURE_READABLE
    ];

    public function __construct(int $clientId, int $workerId)
    {
        $this->clientId = $clientId;
        $this->workerId = $workerId;
    }

    public function addAction(Actions $action): void
    {
        $this->actions[$action->getInnerName()] = $action;
    }

    /**
     * Get next task status if the passed action is applied
     * 
     * @param Actions $action
     * @return string status identifier
     */
    public function nextStatus(Actions $action): ?string
    {
        $statusSwitch = [
            "Завершить задание" => self::STATUS_COMPLETED,
            "Отказаться" => self::STATUS_FAILED,
            AbortAction::INNER_NAME => self::STATUS_ABORTED,
            "Откликнуться" => self::STATUS_IN_WORK
        ];
        
        return $statusSwitch[$action->getInnerName()] ?? null;
    }

    public function getActionMap(): array
    {
        return $this->actionMap;

    }

    public function getStatusMap(): array
    {
        return $this->statusMap;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
    
    public function setStatus(string $newStatus): void
    {
        if (! in_array($newStatus, array_keys($this->statusMap))) {
            throw new \Exception('Trying to set wrong status');
        }
        $this->status = $newStatus;
    }
    
    /**
     * Get actions list for current task status
     * 
     * @param int $userId current user id
     * @return array
     */
    public function actions(int $userId): array
    {
        $result = [];
        
        switch ($this->status) {
            
            case self::STATUS_NEW:
                
                if($this->actions[AbortAction::INNER_NAME]->rightsCheck($this->clientId, $this->workerId, $userId)) {
                    $result[] = $this->actions[AbortAction::INNER_NAME];
                }

                if($this->actions[ResponseAction::INNER_NAME]->rightsCheck($this->clientId, $this->workerId, $userId)) {
                    $result[] = $this->actions[ResponseAction::INNER_NAME];
                }

                break;
                
            case self::STATUS_IN_WORK:
                $result[] = self::ACTION_FAILURE;
                $result[] = self::ACTION_COMPLETE;
                break;
            case self::STATUS_FAILED:
                $result[] = self::ACTION_RESPONSE;
                break;
            case self::STATUS_ABORTED:
                $result = null;
                break;
            case self::STATUS_COMPLETED:
                $result = null;
                break;
        }
        return $result;
    }
}
