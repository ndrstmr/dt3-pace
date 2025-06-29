<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Event;

use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;

/**
 * Event dispatched after a session's status changed.
 */
final class SessionStatusChangedEvent
{
    public function __construct(
        private readonly Session $session,
        private readonly SessionStatus $previousStatus,
        private readonly SessionStatus $newStatus
    ) {
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function getPreviousStatus(): SessionStatus
    {
        return $this->previousStatus;
    }

    public function getNewStatus(): SessionStatus
    {
        return $this->newStatus;
    }
}
