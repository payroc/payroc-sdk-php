<?php

namespace Payroc\Types;

enum AchPayloadAccountType: string
{
    case Checking = "checking";
    case Savings = "savings";
}
