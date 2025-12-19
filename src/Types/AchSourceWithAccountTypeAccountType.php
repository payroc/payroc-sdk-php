<?php

namespace Payroc\Types;

enum AchSourceWithAccountTypeAccountType: string
{
    case Checking = "checking";
    case Savings = "savings";
}
