<?php

namespace Payroc\PaymentLinks\Types;

enum ListPaymentLinksRequestStatus: string
{
    case Active = "active";
    case Completed = "completed";
    case Deactivated = "deactivated";
    case Expired = "expired";
}
