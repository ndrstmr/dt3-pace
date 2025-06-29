<?php
use Ndrstmr\Dt3Pace\Controller\SessionVoteController;
use Ndrstmr\Dt3Pace\Controller\SessionApiController;
use Ndrstmr\Dt3Pace\Controller\NoteApiController;

return [
    'dt3pace_session_vote' => [
        'path' => '/dt3pace/session/vote',
        'target' => SessionVoteController::class . '::voteAction',
        'methods' => ['POST'],
    ],
    'dt3pace_sessions_json' => [
        'path' => '/dt3pace/sessions/json',
        'target' => SessionApiController::class . '::listJsonAction',
    ],
    'dt3pace_note_update' => [
        'path' => '/dt3pace/note/update',
        'target' => NoteApiController::class . '::updateAction',
        'methods' => ['POST'],
    ],
];
