<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Tests\Unit\Template;

use PHPUnit\Framework\TestCase;

class TemplateOutputTest extends TestCase
{
    public function testSessionDescriptionUsesHtmlFormatter(): void
    {
        $template = file_get_contents(__DIR__ . '/../../../Resources/Private/Templates/Session/Show.html');
        $this->assertStringContainsString('<f:format.html>{session.description}</f:format.html>', (string) $template);
    }

    public function testSpeakerBioUsesHtmlFormatter(): void
    {
        $template = file_get_contents(__DIR__ . '/../../../Resources/Private/Templates/Speaker/Show.html');
        $this->assertStringContainsString('<f:format.html>{speaker.bio}</f:format.html>', (string) $template);
    }
}
