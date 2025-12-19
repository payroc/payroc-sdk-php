<?php

namespace Payroc\Types;

enum EventSubscriptionStatus: string
{
    case Registered = "registered";
    case Suspended = "suspended";
    case Failed = "failed";
}
