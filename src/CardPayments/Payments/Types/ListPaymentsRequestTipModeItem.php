<?php

namespace Payroc\CardPayments\Payments\Types;

enum ListPaymentsRequestTipModeItem: string
{
    case NoTip = "noTip";
    case Prompted = "prompted";
    case Adjusted = "adjusted";
}
