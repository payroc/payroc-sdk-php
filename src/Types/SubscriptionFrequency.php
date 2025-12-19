<?php

namespace Payroc\Types;

enum SubscriptionFrequency: string
{
    case Weekly = "weekly";
    case Fortnightly = "fortnightly";
    case Monthly = "monthly";
    case Quarterly = "quarterly";
    case Yearly = "yearly";
}
