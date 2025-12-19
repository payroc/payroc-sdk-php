<?php

namespace Payroc\RepeatPayments\Subscriptions\Types;

enum ListSubscriptionsRequestStatus: string
{
    case Active = "active";
    case Completed = "completed";
    case Suspended = "suspended";
    case Cancelled = "cancelled";
}
