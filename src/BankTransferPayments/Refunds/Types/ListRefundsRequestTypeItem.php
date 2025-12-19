<?php

namespace Payroc\BankTransferPayments\Refunds\Types;

enum ListRefundsRequestTypeItem: string
{
    case Refund = "refund";
    case UnreferencedRefund = "unreferencedRefund";
}
