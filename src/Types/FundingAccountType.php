<?php

namespace Payroc\Types;

enum FundingAccountType: string
{
    case Checking = "checking";
    case Savings = "savings";
    case GeneralLedger = "generalLedger";
}
