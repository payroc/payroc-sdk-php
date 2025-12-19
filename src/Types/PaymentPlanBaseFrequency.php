<?php

namespace Payroc\Types;

enum PaymentPlanBaseFrequency: string
{
    case Weekly = "weekly";
    case Fortnightly = "fortnightly";
    case Monthly = "monthly";
    case Quarterly = "quarterly";
    case Yearly = "yearly";
}
