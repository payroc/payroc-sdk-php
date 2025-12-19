<?php

namespace Payroc\Types;

enum MultiUsePaymentLinkStatus: string
{
    case Active = "active";
    case Completed = "completed";
    case Deactivated = "deactivated";
    case Expired = "expired";
}
