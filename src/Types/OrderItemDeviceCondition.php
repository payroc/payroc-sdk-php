<?php

namespace Payroc\Types;

enum OrderItemDeviceCondition: string
{
    case New_ = "new";
    case Refurbished = "refurbished";
}
