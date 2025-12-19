<?php

namespace Payroc\Types;

enum TransactionType: string
{
    case Capture = "capture";
    case Return_ = "return";
}
