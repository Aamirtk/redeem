<?php

namespace backend\modules\opportunity\consumers;

use yii;
use yii\amqp\components\AmqpInterpreter;
use backend\modules\opportunity\services\PushService;

class PushOpportunityConsumer extends AmqpInterpreter
{
    public function readPushOpportunityRouting($message)
    {
        $this->log(print_r($message, true));
        $model = new PushService();
        $model->handlePushOpportunityData($message);
    }
}