<?php

namespace Payroc\Types;

enum EbtEnabledEbtType: string
{
    case FoodStamp = "foodStamp";
    case Cash = "cash";
    case Both = "both";
}
