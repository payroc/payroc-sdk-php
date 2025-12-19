<?php

namespace Payroc\Types;

enum RewardPayChoiceFeesCreditTips: string
{
    case NoTips = "noTips";
    case TipPrompt = "tipPrompt";
    case TipAdjust = "tipAdjust";
}
