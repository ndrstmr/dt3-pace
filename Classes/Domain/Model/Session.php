<?php

declare(strict_types=1);

namespace Ndrstmr\Dt3Pace\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\CMS\Extbase\Domain\Model\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use Ndrstmr\Dt3Pace\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Represents a conference session.
 */
#[ORM\Entity]
#[ORM\Table(name: 'tx_dt3pace_domain_model_session')]
class Session extends AbstractEntity
{
    /**
     * Title of the session
     */
    #[ORM\Column(type: 'string', length: 255)]
    protected string $title = '';

    /**
     * Session description
     */
    #[ORM\Column(type: 'text', nullable: true)]
    protected string $description = '';

    /**
     * Current status
     */
    #[ORM\Column(type: 'string', enumType: SessionStatus::class)]
    protected SessionStatus $status = SessionStatus::PROPOSED;

    /**
     * Number of votes
     */
    #[ORM\Column(type: 'integer')]
    protected int $votes = 0;

    /**
     * Publication flag
     */
    #[ORM\Column(type: 'boolean')]
    protected bool $isPublished = false;

    /**
     * Proposing frontend user
     */
    #[ORM\ManyToOne(targetEntity: FrontendUser::class)]
    protected ?FrontendUser $proposer = null;

    /**
     * Assigned speakers
     *
     * @var ObjectStorage<Speaker>
     */
    #[ORM\ManyToMany(targetEntity: Speaker::class)]
    protected ObjectStorage $speakers;

    #[ORM\ManyToOne(targetEntity: Room::class)]
    protected ?Room $room = null;

    #[ORM\ManyToOne(targetEntity: Track::class)]
    protected ?Track $track = null;

    #[ORM\ManyToOne(targetEntity: TimeSlot::class)]
    protected ?TimeSlot $timeSlot = null;

    #[ORM\OneToOne(targetEntity: \TYPO3\CMS\Core\Resource\FileReference::class, cascade: ['persist', 'remove'])]
    protected ?\TYPO3\CMS\Core\Resource\FileReference $slides = null;

    public function __construct()
    {
        $this->speakers = new ObjectStorage();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStatus(): SessionStatus
    {
        return $this->status;
    }

    public function setStatus(SessionStatus $status): void
    {
        $this->status = $status;
    }

    public function getVotes(): int
    {
        return $this->votes;
    }

    public function addVote(): void
    {
        ++$this->votes;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): void
    {
        $this->isPublished = $isPublished;
    }

    public function getProposer(): ?FrontendUser
    {
        return $this->proposer;
    }

    public function setProposer(?FrontendUser $proposer): void
    {
        $this->proposer = $proposer;
    }

    /**
     * @return ObjectStorage<Speaker>
     */
    public function getSpeakers(): ObjectStorage
    {
        return $this->speakers;
    }

    public function addSpeaker(Speaker $speaker): void
    {
        $this->speakers->attach($speaker);
    }

    public function removeSpeaker(Speaker $speaker): void
    {
        $this->speakers->detach($speaker);
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): void
    {
        $this->room = $room;
    }

    public function getTrack(): ?Track
    {
        return $this->track;
    }

    public function setTrack(?Track $track): void
    {
        $this->track = $track;
    }

    public function getTimeSlot(): ?TimeSlot
    {
        return $this->timeSlot;
    }

    public function setTimeSlot(?TimeSlot $timeSlot): void
    {
        $this->timeSlot = $timeSlot;
    }

    public function getSlides(): ?\TYPO3\CMS\Core\Resource\FileReference
    {
        return $this->slides;
    }

    public function setSlides(?\TYPO3\CMS\Core\Resource\FileReference $slides): void
    {
        $this->slides = $slides;
    }
}
