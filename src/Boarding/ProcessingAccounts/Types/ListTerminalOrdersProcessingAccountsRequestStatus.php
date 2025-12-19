<?php

namespace Payroc\Boarding\ProcessingAccounts\Types;

enum ListTerminalOrdersProcessingAccountsRequestStatus: string
{
    case Open = "open";
    case Held = "held";
    case Dispatched = "dispatched";
    case Fulfilled = "fulfilled";
    case Cancelled = "cancelled";
}
