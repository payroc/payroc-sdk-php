<?php

namespace Payroc\Types;

enum SubscriptionType: string
{
    case Manual = "manual";
    case Automatic = "automatic";
}
