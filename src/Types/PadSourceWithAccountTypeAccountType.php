<?php

namespace Payroc\Types;

enum PadSourceWithAccountTypeAccountType: string
{
    case Checking = "checking";
    case Savings = "savings";
}
