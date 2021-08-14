<?php
namespace TaskForce;

const PHP_EOL = '<br/>';

/**
 * Status - класс содержит и изменяет текущее состояние задания
 */
class Status 
{
    protected const STATUS_NEW = 'new';
    protected const STATUS_CANCELED = 'canceled';
    protected const STATUS_WORK = 'work';
    protected const STATUS_DONE = 'done';
    protected const STATUS_FAILED = 'failed';

    private $status;

    protected function __construct() {
        $this->status = self::STATUS_NEW;
    }

    /**
     * Задать новое состояние задания
     * @param string $newStatus - новое состояние задания
     * @throws \LogicException - попытка установить новый статус задания,
     * который не соответствует текущему статусу
     * 
     * @return ничего
     */
    protected function setStatus(string $newStatus) {
        switch ($this->status) {
            case self::STATUS_NEW:
                switch ($newStatus) {
                    case self::STATUS_CANCELED:
                    case self::STATUS_WORK:
                        $this->status = $newStatus;
                        break;
                    default:
                        throw new \LogicException(
                            'Current status: ' . $this->status .
                            '. Wrong new status value: ' . $newStatus .
                            '. Awaited: ' . self::STATUS_CANCELED . ' or ' . self::STATUS_WORK
                        );
                        break;
                }
                break;
            case self::STATUS_FAILED:
                switch ($newStatus) {
                    case self::STATUS_NEW:
                    case self::STATUS_CANCELED:
                        $this->status = $newStatus;
                        break;
                    default:
                        throw new \LogicException(
                            'Current status: ' . $this->status .
                            '. Wrong new status value: ' . $newStatus .
                            '. Awaited: ' . self::STATUS_CANCELED . ' or ' . self::STATUS_NEW
                        );
                        break;
                }
                break;
            case self::STATUS_WORK:
                switch ($newStatus) {
                    case self::STATUS_DONE:
                    case self::STATUS_FAILED:
                        $this->status = $newStatus;
                        break;
                    default:
                        throw new \LogicException(
                            'Current status: ' . $this->status .
                            '. Wrong new status value: '. $newStatus .
                            '. Awaited: ' . self::STATUS_DONE . ' or ' . self::STATUS_FAILED
                        );
                        break;
                }
                break;
            case self::STATUS_DONE:
            case self::STATUS_CANCELED:
                throw new \LogicException(
                    'Current status: ' . $this->status .
                    '. Any other status value not allowed'
                );
                break;
        }
    }

    /**
     * Показать текущее состояние задания
     * @param ничего
     * 
     * @return string текушее состояние задания
     */
    public function getStatus() : string {
        return $this->status;
    }
}

/**
 * Task - класс описания задания и работы с ним
 */
class Task extends Status
{
    private $customer;
    private $contractor;

    /**
     * Конструктор класса
     * @param int $customerId - id заказчика задания
     */
    public function __construct(int $customerId) {
        parent::__construct();
        $this->customer = $customerId;
        $this->contractor = 0;
        echo 'construct() новое задание', PHP_EOL;
    }

    /**
     * Задать исполнителя задания
     * @param int $contractorId - id исполнителя задания
     * @throws \LogicException - при текушем статусе задания задать 
     * исполнителя невозможно
     * 
     * @return ничего
     */
    public function setContractor(int $contractorId) {
        if ($this->getStatus() === self::STATUS_NEW) {
            $this->contractor = $contractorId;
        } else {
            throw new \LogicException(
                'Current status: ' . $this->getStatus() .
                '. Contractor set not allowed' .
                '. Allowed by status: ' . self::STATUS_NEW
            );
        }
    }

    /**
     * Получить id исполнителя задания
     * @param ничего
     * 
     * @return int id исполнителя
     */
    public function getContractorId() {
        return $this->contractor;
    }

    /**
     * Получить id заказчика задания
     * @param ничего
     * 
     * @return int id заказчика
     */
    public function getCustomerId() {
        return $this->customer;
    }

    /**
     * Отказаться от выполнения задания
     * @param ничего
     * 
     * @return ничего
     */
    public function refuse() {
        try {
            $this->setStatus(self::STATUS_FAILED);
            echo 'Отказ от выполнения задания выполнен', PHP_EOL;
        } catch (\LogicException $e) {
            echo 'refuse() перехвачено исключение: ',  $e->getMessage(), PHP_EOL;
        }
    }

    /**
     * Отменить задание
     * @param ничего
     * 
     * @return ничего
     */
    public function cancel() {
        try {
            $this->setStatus(self::STATUS_CANCELED);
            echo 'Задание отменено', PHP_EOL;
        } catch (\LogicException $e) {
            echo 'cancel() перехвачено исключение: ',  $e->getMessage(), PHP_EOL;
        }
    }

    /**
     * Стартовать выполнение задания
     * @param ничего
     * 
     * @return ничего
     */
    public function start() {
        if ($this->contractor === 0) {
            throw new \LogicException('Task start not allowed. Contractor not defined');
        }
        try {
            $this->setStatus(self::STATUS_WORK);
            echo 'Задание поставлено на выполнение', PHP_EOL;
        } catch (\LogicException $e) {
            echo 'start() перехвачено исключение: ',  $e->getMessage(), PHP_EOL;
        }
    }

    /**
     * Обновить задание после отказа от его выполнения
     * @param ничего
     * 
     * @return ничего
     */
    public function renew() {
        try {
            $this->setStatus(self::STATUS_NEW);
            $this->setContractor(0);
            echo 'Задание снова можно стартовать', PHP_EOL;
        } catch (\LogicException $e) {
            echo 'renew() перехвачено исключение: ',  $e->getMessage(), PHP_EOL;
        }
    }
    /**
     * Завершить выполнение задания
     * @param ничего
     * 
     * @return ничего
     */
    public function complete() {
        try {
            $this->setStatus(self::STATUS_DONE);
            echo 'Задание выполнено', PHP_EOL;
        } catch (\LogicException $e) {
            echo 'complete() перехвачено исключение: ',  $e->getMessage(), PHP_EOL;
        }
    }
}
