<?php

namespace Payroc\CardPayments\Refunds\Types;

enum UnreferencedRefundChannel: string
{
    case Pos = "pos";
    case Moto = "moto";
}
