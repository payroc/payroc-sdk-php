<?php

namespace Payroc\CardPayments\Refunds\Types;

enum ListRefundsRequestSettlementState: string
{
    case Settled = "settled";
    case Unsettled = "unsettled";
}
