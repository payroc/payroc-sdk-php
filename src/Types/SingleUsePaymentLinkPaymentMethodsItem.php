<?php

namespace Payroc\Types;

enum SingleUsePaymentLinkPaymentMethodsItem: string
{
    case Card = "card";
    case BankTransfer = "bankTransfer";
}
