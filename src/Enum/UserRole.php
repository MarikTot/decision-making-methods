<?php

namespace App\Enum;

interface UserRole
{
    public const ADMIN = 'ROLE_ADMIN';
    public const TEACHER = 'ROLE_TEACHER';
    public const STUDENT = 'ROLE_STUDENT';
    public const USER = 'ROLE_USER';
}
