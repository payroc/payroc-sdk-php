<?php

namespace Payroc\PaymentLinks\Types;

enum ListPaymentLinksRequestLinkType: string
{
    case MultiUse = "multiUse";
    case SingleUse = "singleUse";
}
