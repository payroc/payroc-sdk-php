<?php

namespace Payroc\BankTransferPayments\Payments\Types;

enum ListPaymentsRequestTypeItem: string
{
    case Payment = "payment";
    case AccountVerification = "accountVerification";
}
