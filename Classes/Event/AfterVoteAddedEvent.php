<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Event;

use Ndrstmr\Dt3Pace\Domain\Model\Vote;

/**
 * Event dispatched after a vote was added and persisted.
 */
final class AfterVoteAddedEvent
{
    public function __construct(private readonly Vote $vote)
    {
    }

    public function getVote(): Vote
    {
        return $this->vote;
    }
}
