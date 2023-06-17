<?php

namespace App\Enums;

enum ApiStatuses: string
{
    case ACTIVE = "Active";
    case INACTIVE = "Inactive";
    case PENDING = "Pending";
    case TERMINATED = "Terminated";
}
