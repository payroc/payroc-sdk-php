<?php

namespace Payroc\Types;

enum SubscriptionStateStatus: string
{
    case Active = "active";
    case Completed = "completed";
    case Suspended = "suspended";
    case Cancelled = "cancelled";
}
