<?php

namespace Payroc\Notifications\EventSubscriptions\Types;

enum ListEventSubscriptionsRequestStatus: string
{
    case Registered = "registered";
    case Suspended = "suspended";
    case Failed = "failed";
}
