<?php

namespace Payroc\Types;

enum SupportedOperationsItem: string
{
    case Capture = "capture";
    case Refund = "refund";
    case FullyReverse = "fullyReverse";
    case PartiallyReverse = "partiallyReverse";
    case IncrementAuthorization = "incrementAuthorization";
    case AdjustTip = "adjustTip";
    case AddSignature = "addSignature";
    case SetAsReady = "setAsReady";
    case SetAsPending = "setAsPending";
}
