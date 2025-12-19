<?php

namespace Payroc\Types;

enum PaymentPlanBaseOnDelete: string
{
    case Complete = "complete";
    case Continue_ = "continue";
}
