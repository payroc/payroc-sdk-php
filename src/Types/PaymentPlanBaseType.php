<?php

namespace Payroc\Types;

enum PaymentPlanBaseType: string
{
    case Manual = "manual";
    case Automatic = "automatic";
}
