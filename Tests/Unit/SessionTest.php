<?php
declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Tests\Unit;

use Ndrstmr\Dt3Pace\Domain\Model\Session;
use Ndrstmr\Dt3Pace\Domain\Model\SessionStatus;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ndrstmr\Dt3Pace\Domain\Model\Session
 */
class SessionTest extends TestCase
{
    public function testDefaultStatusIsProposed(): void
    {
        $session = new Session();
        self::assertSame(SessionStatus::PROPOSED, $session->getStatus());
    }

    public function testAddVoteIncreasesCount(): void
    {
        $session = new Session();
        $session->addVote();
        self::assertSame(1, $session->getVotes());
    }
}
