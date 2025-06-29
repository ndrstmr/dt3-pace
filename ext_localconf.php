<?php
declare(strict_types=1);

use Ndrstmr\Dt3Pace\Controller\SessionController;
use Ndrstmr\Dt3Pace\Controller\SessionListController;
use Ndrstmr\Dt3Pace\Controller\SessionProposalController;
use Ndrstmr\Dt3Pace\Controller\SessionVoteController;
use Ndrstmr\Dt3Pace\Controller\SessionApiController;
use Ndrstmr\Dt3Pace\Controller\SpeakerController;
use Ndrstmr\Dt3Pace\Controller\NoteController;
use Ndrstmr\Dt3Pace\Controller\NoteApiController;
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

foreach (require __DIR__ . '/Configuration/Frontend/AjaxRoutes.php' as $identifier => $config) {
    $GLOBALS['TYPO3_CONF_VARS']['FE']['ajaxRoutes'][$identifier] = $config + [
        'access' => \TYPO3\CMS\Frontend\Middleware\FrontendAjaxMiddleware::class,
        'csrf' => true,
    ];
}
