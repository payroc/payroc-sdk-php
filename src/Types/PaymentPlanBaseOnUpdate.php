<?php

namespace Payroc\Types;

enum PaymentPlanBaseOnUpdate: string
{
    case Update = "update";
    case Continue_ = "continue";
}
