<?php

namespace App\Domain\Core\Entity;

use App\Repository\TaskRepository;
use ContainerEAuYU8n\getDebug_ArgumentResolver_BackedEnumResolver_InnerService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    const TYPE_TASK = 'task';
    const TYPE_STORY = 'story';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID, unique:true)]
    private ?string $uuid = null;

    #[ORM\Column(length: 20)]
    private ?string $alias = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Epic $epic = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Release $release = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creationUser = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?User $currentUser = null;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: Worklog::class)]
    private Collection $worklogs;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: Watcher::class)]
    private Collection $watchers;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'tasks')]
    private Collection $taskTag;

    public static function getTypes()
    {
        return [
            'Task' => self::TYPE_TASK,
            'Story' => self::TYPE_STORY
        ];
    }

    public static function getTypesKeys()
    {
        return array_values(self::getTypes());
    }

    public function __construct()
    {
        $this->worklogs = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->watchers = new ArrayCollection();
        $this->taskTag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getEpic(): ?Epic
    {
        return $this->epic;
    }

    public function setEpic(?Epic $epic): self
    {
        $this->epic = $epic;

        return $this;
    }

    public function getRelease(): ?Release
    {
        return $this->release;
    }

    public function setRelease(?Release $release): self
    {
        $this->release = $release;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(?\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreationUser(): ?User
    {
        return $this->creationUser;
    }

    public function setCreationUser(?User $creationUser): self
    {
        $this->creationUser = $creationUser;

        return $this;
    }

    public function getCurrentUser(): ?User
    {
        return $this->currentUser;
    }

    public function setCurrentUser(?User $currentUser): self
    {
        $this->currentUser = $currentUser;

        return $this;
    }

    /**
     * @return Collection<int, Worklog>
     */
    public function getWorklogs(): Collection
    {
        return $this->worklogs;
    }

    public function addWorklog(Worklog $worklog): self
    {
        if (!$this->worklogs->contains($worklog)) {
            $this->worklogs->add($worklog);
            $worklog->setTask($this);
        }

        return $this;
    }

    public function removeWorklog(Worklog $worklog): self
    {
        if ($this->worklogs->removeElement($worklog)) {
            // set the owning side to null (unless already changed)
            if ($worklog->getTask() === $this) {
                $worklog->setTask(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTask($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTask() === $this) {
                $comment->setTask(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Watcher>
     */
    public function getWatchers(): Collection
    {
        return $this->watchers;
    }

    public function addWatcher(Watcher $watcher): self
    {
        if (!$this->watchers->contains($watcher)) {
            $this->watchers->add($watcher);
            $watcher->setTask($this);
        }

        return $this;
    }

    public function removeWatcher(Watcher $watcher): self
    {
        if ($this->watchers->removeElement($watcher)) {
            // set the owning side to null (unless already changed)
            if ($watcher->getTask() === $this) {
                $watcher->setTask(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTaskTag(): Collection
    {
        return $this->taskTag;
    }

    public function addTaskTag(Tag $taskTag): self
    {
        if (!$this->taskTag->contains($taskTag)) {
            $this->taskTag->add($taskTag);
        }

        return $this;
    }

    public function removeTaskTag(Tag $taskTag): self
    {
        $this->taskTag->removeElement($taskTag);

        return $this;
    }
}
