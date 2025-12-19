<?php

namespace Payroc\Types;

enum TransactionSummaryType: string
{
    case Capture = "capture";
    case Return_ = "return";
}
