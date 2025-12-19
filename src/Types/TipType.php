<?php

namespace Payroc\Types;

enum TipType: string
{
    case Percentage = "percentage";
    case FixedAmount = "fixedAmount";
}
