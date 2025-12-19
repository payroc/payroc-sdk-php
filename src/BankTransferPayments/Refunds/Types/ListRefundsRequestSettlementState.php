<?php

namespace Payroc\BankTransferPayments\Refunds\Types;

enum ListRefundsRequestSettlementState: string
{
    case Settled = "settled";
    case Unsettled = "unsettled";
}
