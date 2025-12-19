<?php

namespace Payroc\PaymentFeatures\Cards\Types;

enum FxRateInquiryChannel: string
{
    case Pos = "pos";
    case Web = "web";
    case Moto = "moto";
}
