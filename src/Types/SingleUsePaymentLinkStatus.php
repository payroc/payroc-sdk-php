<?php

namespace Payroc\Types;

enum SingleUsePaymentLinkStatus: string
{
    case Active = "active";
    case Completed = "completed";
    case Deactivated = "deactivated";
    case Expired = "expired";
}
