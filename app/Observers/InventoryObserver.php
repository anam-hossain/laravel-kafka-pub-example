<?php

namespace App\Observers;

use App\Handlers\ProducerHandler;
use App\Inventory;
use Exception;
use Illuminate\Support\Facades\Log;

class InventoryObserver
{
    /**
     * Topic name
     */
    const KAFKA_TOPIC = 'inventories';

    /**
     * Publish error message
     */
    const PUBLISH_ERROR_MESSAGE = 'Publish message to kafka failed';

    /**
     * Kafka producer
     *
     * @var \App\Handlers\Kafka\ProducerHandler
     */
    protected $producerHandler;

    /**
     * InventoryObserver's constructor
     *
     * @param \App\Handlers\Kafka\ProducerHandler $producerHandler
     */
    public function __construct(ProducerHandler $producerHandler)
    {
        $this->producerHandler = $producerHandler;
    }

    /**
     * Handle the inventory "created" event.
     *
     * @param  \App\Inventory $inventory
     * @return void
     */
    public function created(Inventory $inventory)
    {
        $this->pushToKafka($inventory);
    }

    /**
     * Handle the inventory "updated" event.
     *
     * @param  \App\Inventory $inventory
     * @return void
     */
    public function updated(Inventory $inventory)
    {
        $this->pushToKafka($inventory);
    }

    /**
     * Handle the inventory "deleted" event.
     *
     * @param  \App\Inventory $inventory
     * @return void
     */
    public function deleted(Inventory $inventory)
    {
        $this->pushToKafka($inventory);
    }

    /**
     * Push inventory to kafka
     *
     * @param  \App\Inventory $inventory
     * @return void
     */
    protected function pushToKafka(Inventory $inventory)
    {
        try {
            $this->producerHandler->setTopic(self::KAFKA_TOPIC)
                ->send($inventory->toJson(), $inventory->id);
        } catch (Exception $e) {
            Log::critical(self::PUBLISH_ERROR_MESSAGE, [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
