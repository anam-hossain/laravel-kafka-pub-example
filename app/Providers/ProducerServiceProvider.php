<?php

namespace App\Providers;

use RdKafka\Conf;
use RdKafka\Producer;
use Illuminate\Support\ServiceProvider;

class ProducerServiceProvider extends ServiceProvider
{
    /**
     * Boot method
     *
     * @return void
     */
    public function boot()
    {
        $conf = new Conf();

        $conf->set('metadata.broker.list', env('KAFKA_BROKERS', '127.0.0.1'));
        
        $conf->set('compression.type', 'snappy');
        
        if (env('KAFKA_DEBUG', false)) {
            $conf->set('log_level', LOG_DEBUG);
            $conf->set('debug', 'all');
        }
 
        $this->app->bind(Producer::class, function () use ($conf) {
            return new Producer($conf);
        });
    }
}
