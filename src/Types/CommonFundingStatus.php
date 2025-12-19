<?php

namespace Payroc\Types;

enum CommonFundingStatus: string
{
    case Enabled = "enabled";
    case Disabled = "disabled";
}
