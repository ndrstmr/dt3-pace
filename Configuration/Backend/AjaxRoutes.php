<?php
use Ndrstmr\Dt3Pace\Controller\SchedulerController;

return [
    'dt3pace_scheduler_update' => [
        'path' => '/dt3pace/scheduler/update',
        'target' => SchedulerController::class . '::updateSessionSlotAction',
        'access' => 'user',
        'methods' => ['POST'],
    ],
];
