<?php
namespace TaskForce;

/**
 * Task - класс описания задания и работы с ним
 */
class Task
{
    private const STATUS_NEW = 'new';
    private const STATUS_CANCELED = 'canceled';
    private const STATUS_WORK = 'work';
    private const STATUS_DONE = 'done';
    private const STATUS_FAILED = 'failed';

    //id заказчика
    private $customer;
    //id исполнителя
    private $contractor;
    //статус состояния задачи
    private $status;

    /**
     * Конструктор класса
     * @param int $customerId - id заказчика задания
     * @param int $contractorId - id исполнителя задания
     */
    public function __construct(int $customerId, int $contractorId) {
        $this->customer = $customerId;
        $this->contractor = $contractorId;
        $this->status = self::STATUS_NEW;
        echo 'construct() новое задание', \PHP_EOL;
        echo $this->status, \PHP_EOL;
    }

    /**
     * Вспомогательная функция проверяет новый статус задания на соответствие логике переходов
     * из одного состояния в другое и меняет текущий статус задания на новый
     * @param string $newStatus - новый статус задания
     */
    private function setStatus(string $newStatus) {
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
     * Отказаться от выполнения задания
     */
    public function refuse() : string {
        try {
            $this->setStatus(self::STATUS_FAILED);
            echo 'Отказ от выполнения задания выполнен', \PHP_EOL;
        } catch (\LogicException $e) {
            echo 'refuse() перехвачено исключение: ',  $e->getMessage(), \PHP_EOL;
        }
        return $this->status;
    }

    /**
     * Отменить задание
     */
    public function cancel() : string {
        try {
            $this->setStatus(self::STATUS_CANCELED);
            echo 'Задание отменено', \PHP_EOL;
        } catch (\LogicException $e) {
            echo 'cancel() перехвачено исключение: ',  $e->getMessage(), \PHP_EOL;
        }
        return $this->status;
    }

    /**
     * Стартовать выполнение задания
     */
    public function start() : string {
        try {
            $this->setStatus(self::STATUS_WORK);
            echo 'Задание поставлено на выполнение', \PHP_EOL;
        } catch (\LogicException $e) {
            echo 'start() перехвачено исключение: ',  $e->getMessage(), \PHP_EOL;
        }
        return $this->status;
    }

    /**
     * Завершить выполнение задания
     */
    public function complete() : string {
        try {
            $this->setStatus(self::STATUS_DONE);
            echo 'Задание выполнено', \PHP_EOL;
        } catch (\LogicException $e) {
            echo 'complete() перехвачено исключение: ',  $e->getMessage(), \PHP_EOL;
        }
        return $this->status;
    }
}
