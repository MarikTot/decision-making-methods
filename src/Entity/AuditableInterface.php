<?php

namespace App\Entity;

interface AuditableInterface
{
    public function getCreatedBy(): User;
}
