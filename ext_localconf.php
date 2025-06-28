<?php
declare(strict_types=1);

use Ndrstmr\Dt3Pace\Controller\SessionController;
use Ndrstmr\Dt3Pace\Controller\SpeakerController;
use Ndrstmr\Dt3Pace\Controller\NoteController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Agendalist', [
    SessionController::class => 'list,show'
], []);

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Agendagrid', [
    SessionController::class => 'grid,listJson'
], [SessionController::class => 'listJson']);

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Sessionshow', [
    SessionController::class => 'show'
], []);

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Speakerlist', [
    SpeakerController::class => 'list,show'
], []);

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Speakershow', [
    SpeakerController::class => 'show'
], []);

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Sessionform', [
    SessionController::class => 'new,create'
], [SessionController::class => 'create']);

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Sessionvoting', [
    SessionController::class => 'listProposals,vote'
], [SessionController::class => 'vote']);

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Eventsummary', [
    NoteController::class => 'summary'
], []);

$GLOBALS['TYPO3_CONF_VARS']['FE']['ajaxRoutes']['dt3pace_session_vote'] = [
    'path' => '/dt3pace/session/vote',
    'target' => SessionController::class . '::voteAction',
    'access' => 'public',
    'methods' => ['POST'],
];

$GLOBALS['TYPO3_CONF_VARS']['FE']['ajaxRoutes']['dt3pace_sessions_json'] = [
    'path' => '/dt3pace/sessions/json',
    'target' => SessionController::class . '::listJsonAction',
    'access' => 'public',
];

$GLOBALS['TYPO3_CONF_VARS']['FE']['ajaxRoutes']['dt3pace_note_update'] = [
    'path' => '/dt3pace/note/update',
    'target' => NoteController::class . '::updateAction',
    'access' => 'public',
    'methods' => ['POST'],
];
