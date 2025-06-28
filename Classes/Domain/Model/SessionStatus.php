<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Model;

/**
 * Status of a session proposal.
 */
enum SessionStatus: string
{
    case PROPOSED = 'proposed';
    case SCHEDULED = 'scheduled';
    case REJECTED = 'rejected';
}
