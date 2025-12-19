<?php

namespace Payroc\Types;

enum BankTransferResultType: string
{
    case Payment = "payment";
    case Refund = "refund";
    case UnreferencedRefund = "unreferencedRefund";
    case AccountVerification = "accountVerification";
}
