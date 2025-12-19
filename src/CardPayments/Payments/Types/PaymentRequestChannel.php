<?php

namespace Payroc\CardPayments\Payments\Types;

enum PaymentRequestChannel: string
{
    case Pos = "pos";
    case Web = "web";
    case Moto = "moto";
}
