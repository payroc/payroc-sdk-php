<?php

namespace Payroc\RepeatPayments\Subscriptions\Types;

enum ListSubscriptionsRequestFrequency: string
{
    case Weekly = "weekly";
    case Fortnightly = "fortnightly";
    case Monthly = "monthly";
    case Quarterly = "quarterly";
    case Yearly = "yearly";
}
