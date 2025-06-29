<?php
declare(strict_types=1);

use Ndrstmr\Dt3Pace\Controller\SessionController;
use Ndrstmr\Dt3Pace\Controller\SessionListController;
use Ndrstmr\Dt3Pace\Controller\SessionProposalController;
use Ndrstmr\Dt3Pace\Controller\SessionVoteController;
use Ndrstmr\Dt3Pace\Controller\SessionApiController;
use Ndrstmr\Dt3Pace\Controller\SpeakerController;
use Ndrstmr\Dt3Pace\Controller\NoteController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Agendalist', [
    SessionListController::class => 'list',
    SessionController::class => 'show'
], []);

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Agendagrid', [
    SessionListController::class => 'grid',
    SessionApiController::class => 'listJson'
], [SessionApiController::class => 'listJson']);

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
    SessionProposalController::class => 'new,create'
], [SessionProposalController::class => 'create']);

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Sessionvoting', [
    SessionProposalController::class => 'listProposals',
    SessionVoteController::class => 'vote'
], [SessionVoteController::class => 'vote']);

ExtensionUtility::configurePlugin('Ndrstmr.Dt3Pace', 'Eventsummary', [
    NoteController::class => 'summary'
], []);

$GLOBALS['TYPO3_CONF_VARS']['FE']['ajaxRoutes']['dt3pace_session_vote'] = [
    'path' => '/dt3pace/session/vote',
    'target' => SessionVoteController::class . '::voteAction',
    'access' => 'public',
    'methods' => ['POST'],
];

$GLOBALS['TYPO3_CONF_VARS']['FE']['ajaxRoutes']['dt3pace_sessions_json'] = [
    'path' => '/dt3pace/sessions/json',
    'target' => SessionApiController::class . '::listJsonAction',
    'access' => 'public',
];

$GLOBALS['TYPO3_CONF_VARS']['FE']['ajaxRoutes']['dt3pace_note_update'] = [
    'path' => '/dt3pace/note/update',
    'target' => NoteController::class . '::updateAction',
    'access' => 'public',
    'methods' => ['POST'],
];
