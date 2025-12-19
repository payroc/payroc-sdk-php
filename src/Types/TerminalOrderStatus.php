<?php

namespace Payroc\Types;

enum TerminalOrderStatus: string
{
    case Open = "open";
    case Held = "held";
    case Dispatched = "dispatched";
    case Fulfilled = "fulfilled";
    case Cancelled = "cancelled";
}
