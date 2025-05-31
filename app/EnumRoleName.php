<?php

namespace App;

enum EnumRoleName :string
{
    case SUPERADMIN    = 'superAdmin';
    case ADMIN   = 'admin';
    case USER    = 'user';
}
