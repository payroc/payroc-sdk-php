<?php

namespace Payroc\CardPayments\Payments\Types;

enum ListPaymentsRequestSettlementState: string
{
    case Settled = "settled";
    case Unsettled = "unsettled";
}
