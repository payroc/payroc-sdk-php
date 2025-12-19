<?php

namespace Payroc\Types;

enum RewardPayFeesTips: string
{
    case NoTips = "noTips";
    case TipPrompt = "tipPrompt";
    case TipAdjust = "tipAdjust";
}
