<?php

namespace Payroc\Types;

enum DualPricingAlternativeTender: string
{
    case Card = "card";
    case Cash = "cash";
    case BankTransfer = "bankTransfer";
}
