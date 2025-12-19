<?php

namespace Payroc\Types;

enum StatusAdjustmentToStatus: string
{
    case Ready = "ready";
    case Pending = "pending";
}
