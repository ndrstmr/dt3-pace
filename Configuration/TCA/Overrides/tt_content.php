<?php
declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionUtility::registerPlugin('Ndrstmr.Dt3Pace', 'Agendalist', 'Agenda List');
ExtensionUtility::registerPlugin('Ndrstmr.Dt3Pace', 'Agendagrid', 'Agenda Grid');
ExtensionUtility::registerPlugin('Ndrstmr.Dt3Pace', 'Sessionshow', 'Session Detail');
ExtensionUtility::registerPlugin('Ndrstmr.Dt3Pace', 'Speakerlist', 'Speaker List');
ExtensionUtility::registerPlugin('Ndrstmr.Dt3Pace', 'Speakershow', 'Speaker Detail');
ExtensionUtility::registerPlugin('Ndrstmr.Dt3Pace', 'Sessionform', 'Session Proposal');
ExtensionUtility::registerPlugin('Ndrstmr.Dt3Pace', 'Sessionvoting', 'Proposal Voting');
