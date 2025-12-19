<?php

namespace Payroc\Types;

enum FundingAccountUse: string
{
    case Credit = "credit";
    case Debit = "debit";
    case CreditAndDebit = "creditAndDebit";
}
