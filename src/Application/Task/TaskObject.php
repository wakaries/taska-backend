<?php

namespace App\Application\Task;

use App\Domain\Core\Entity\Task;
use App\Domain\Core\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

#[App\Validator\Task]
class TaskObject
{
    #[Assert\NotBlank]
    private ?string $uuid = null;
    #[Assert\NotBlank]
    private ?string $alias = null;
    #[Assert\NotBlank]
    private ?string $epic = null;

    private ?string $release = null;
    #[Assert\NotBlank]
    private ?\DateTimeInterface $creationDate = null;
    #[Assert\NotBlank]
    private ?string $title = null;

    #[Assert\NotBlank]
    private ?string $description = null;
    #[Assert\NotBlank]
    #[Assert\Choice(callback: [Task::class, 'getTypesKeys'])]
    private ?string $type = null;
    #[Assert\NotBlank]
    #[App\Infrastructure\Symfony\Validator\Entity(User::class)]
    private ?string $creationUser = null;

    private ?string $currentUser = null;

    private ?string $status = null;

    /**
     * @return string|null
     */
    public function getUuid(): ?string {
        return $this->uuid;
    }

    /**
     * @param string|null $uuid
     */
    public function setUuid(?string $uuid): void {
        $this->uuid = $uuid;
    }

    /**
     * @return string|null
     */
    public function getAlias(): ?string {
        return $this->alias;
    }

    /**
     * @param string|null $alias
     */
    public function setAlias(?string $alias): void {
        $this->alias = $alias;
    }

    /**
     * @return string|null
     */
    public function getEpic(): ?string {
        return $this->epic;
    }

    /**
     * @param string|null $epic
     */
    public function setEpic(?string $epic): void {
        $this->epic = $epic;
    }

    /**
     * @return string|null
     */
    public function getRelease(): ?string {
        return $this->release;
    }

    /**
     * @param string|null $release
     */
    public function setRelease(?string $release): void {
        $this->release = $release;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreationDate(): ?\DateTimeInterface {
        return $this->creationDate;
    }

    /**
     * @param \DateTimeInterface|null $creationDate
     */
    public function setCreationDate(?\DateTimeInterface $creationDate): void {
        $this->creationDate = $creationDate;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getCreationUser(): ?string {
        return $this->creationUser;
    }

    /**
     * @param string|null $creationUser
     */
    public function setCreationUser(?string $creationUser): void {
        $this->creationUser = $creationUser;
    }

    /**
     * @return string|null
     */
    public function getCurrentUser(): ?string {
        return $this->currentUser;
    }

    /**
     * @param string|null $currentUser
     */
    public function setCurrentUser(?string $currentUser): void {
        $this->currentUser = $currentUser;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void {
        $this->status = $status;
    }


}