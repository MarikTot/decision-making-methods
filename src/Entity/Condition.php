<?php

namespace App\Entity;

use App\Enum\ConditionType;
use App\Repository\ConditionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'conditions')]
#[ORM\Entity(repositoryClass: ConditionRepository::class)]
class Condition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Characteristic $characteristic;

    #[Assert\Choice([ConditionType::MAX, ConditionType::MIN])]
    #[ORM\Column(length: 50)]
    private string $type;

    #[ORM\ManyToOne(inversedBy: 'conditions')]
    private ?Task $task = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCharacteristic(): Characteristic
    {
        return $this->characteristic;
    }

    public function setCharacteristic(Characteristic $characteristic): self
    {
        $this->characteristic = $characteristic;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }
}
