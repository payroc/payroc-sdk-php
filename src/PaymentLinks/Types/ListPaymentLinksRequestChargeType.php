<?php

namespace Payroc\PaymentLinks\Types;

enum ListPaymentLinksRequestChargeType: string
{
    case Preset = "preset";
    case Prompt = "prompt";
}
