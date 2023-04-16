<?php

namespace App\Entity;

use App\Repository\MatrixRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'matrices')]
#[ORM\Entity(repositoryClass: MatrixRepository::class)]
class Matrix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Alternative $alternative = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Characteristic $characteristic = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Task $task = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlternative(): ?Alternative
    {
        return $this->alternative;
    }

    public function setAlternative(?Alternative $alternative): self
    {
        $this->alternative = $alternative;

        return $this;
    }

    public function getCharacteristic(): ?Characteristic
    {
        return $this->characteristic;
    }

    public function setCharacteristic(?Characteristic $characteristic): self
    {
        $this->characteristic = $characteristic;

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
