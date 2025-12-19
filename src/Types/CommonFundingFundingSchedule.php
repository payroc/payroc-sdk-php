<?php

namespace Payroc\Types;

enum CommonFundingFundingSchedule: string
{
    case Standard = "standard";
    case Nextday = "nextday";
    case Sameday = "sameday";
}
