<?php
declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Tests\Unit;

use Ndrstmr\Dt3Pace\Domain\Model\Speaker;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ndrstmr\Dt3Pace\Domain\Model\Speaker
 */
class SpeakerTest extends TestCase
{
    public function testSlugCanBeSet(): void
    {
        $speaker = new Speaker();
        $speaker->setSlug('john-doe');
        self::assertSame('john-doe', $speaker->getSlug());
    }
}
