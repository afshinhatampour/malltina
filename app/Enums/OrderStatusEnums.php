<?php

namespace App\Enums;

enum OrderStatusEnums: string
{
    case CANCEL = 'cancel';

    case WAITING = 'waiting';

    case PREPARATION = 'preparation';

    case READY = 'ready';

    case DELIVERED = 'delivered';
}
