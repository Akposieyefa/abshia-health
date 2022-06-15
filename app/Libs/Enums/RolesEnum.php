<?php

namespace App\Libs\Enums;

enum RolesEnum: string
{
    case SUPERADMIN = 'superadmin';
    case HOSPITAL = 'hospital';
    case AGENT = 'agent';
    case USER = 'user';
}
