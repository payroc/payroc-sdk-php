<?php

namespace Payroc\CardPayments\Payments\Types;

enum ListPaymentsRequestTender: string
{
    case Ebt = "ebt";
    case CreditDebit = "creditDebit";
}
