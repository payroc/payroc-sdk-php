<?php

namespace Payroc\Reporting\Settlement\Types;

enum ListTransactionsSettlementRequestTransactionType: string
{
    case Capture = "Capture";
    case Return_ = "Return";
}
