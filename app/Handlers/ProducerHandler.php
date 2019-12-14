<?php

namespace App\Handlers;

use RdKafka\Producer;
use Exception;

class ProducerHandler
{
    /**
     * Topic missing error message
     */
    const TOPIC_MISSING_ERROR_MESSAGE = 'Topic is not set';

    /**
     * Flush error message
     */
    const FLUSH_ERROR_MESSAGE = 'librdkafka unable to perform flush, messages might be lost';

    /**
     * Message payload
     *
     * @var string
     */
    protected $payload;

    /**
     * Kafka topic
     *
     * @var string
     */
    protected $topic;

    /**
     * RdKafka producer
     *
     * @var \RdKafka\Producer
     */
    protected $producer;

    /**
     * KafkaProducer's constructor
     *
     * @param \RdKafka\Producer $producer
     */
    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    /**
     * Set kafka topic
     *
     * @param string $topic
     * @return $this
     */
    public function setTopic(string $topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return string
     */
    public function getTopic()
    {
        if (!$this->topic) {
            throw new Exception(self::TOPIC_MISSING_ERROR_MESSAGE);
        }

        return $this->topic;
    }

    /**
     * Produce and send a single message to broker
     *
     * @param string $message
     * @param mixed $key
     * @param array $headers
     * @return void
     */
    public function send(string $message, $key = null, array $headers = [])
    {
        $this->buildPayload($message, $headers);
        
        $topic = $this->producer->newTopic($this->getTopic());

        // RD_KAFKA_PARTITION_UA, lets librdkafka choose the partition.
        // Messages with the same "$key" will be in the same topic partition.
        // This ensure that messages are consumed in order.
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $this->payload, $key);

        // pull for any events
        $this->producer->poll(0);

        $this->flush();
    }

    /**
     * librdkafka flush waits for all outstanding producer requests to be handled.
     * It ensures messages produced properly.
     *
     * @param int $timeout "timeout in milliseconds"
     * @return void
     */
    protected function flush(int $timeout = 10000)
    {
        $result = $this->producer->flush($timeout);

        if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
            throw new Exception(self::FLUSH_ERROR_MESSAGE);
        }
    }

    /**
     * Build kafka message payload
     *
     * @param string $message
     * @param array $headers
     * @return void
     */
    protected function buildPayload(string $message, array $headers = [])
    {
        $this->payload = json_encode([
            'body' => $message,
            'headers' => $headers
        ]);
    }
}
