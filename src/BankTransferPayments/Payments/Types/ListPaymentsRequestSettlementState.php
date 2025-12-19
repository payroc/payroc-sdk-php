<?php

namespace Payroc\BankTransferPayments\Payments\Types;

enum ListPaymentsRequestSettlementState: string
{
    case Settled = "settled";
    case Unsettled = "unsettled";
}
