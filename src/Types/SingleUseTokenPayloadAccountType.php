<?php

namespace Payroc\Types;

enum SingleUseTokenPayloadAccountType: string
{
    case Checking = "checking";
    case Savings = "savings";
}
