<?php

namespace Payroc\Types;

enum RewardPayChoiceFeesDebitOption: string
{
    case InterchangePlus = "interchangePlus";
    case FlatRate = "flatRate";
}
