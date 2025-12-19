<?php

namespace Payroc\Types;

enum MultiUsePaymentLinkPaymentMethodsItem: string
{
    case Card = "card";
    case BankTransfer = "bankTransfer";
}
