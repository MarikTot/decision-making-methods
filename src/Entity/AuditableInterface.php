<?php

namespace App\Entity;

use DateTimeImmutable;

interface AuditableInterface
{
    public function getCreatedBy(): ?User;
    public function setCreatedBy(User $createdBy): self;
    public function getCreatedAt(): ?DateTimeImmutable;
    public function setCreatedAt(DateTimeImmutable $createdAt): self;
}
