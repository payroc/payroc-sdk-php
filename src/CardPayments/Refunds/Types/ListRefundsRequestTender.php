<?php

namespace Payroc\CardPayments\Refunds\Types;

enum ListRefundsRequestTender: string
{
    case Ebt = "ebt";
    case CreditDebit = "creditDebit";
}
