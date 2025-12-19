<?php

namespace Payroc\Types;

enum CardEntryMethod: string
{
    case Icc = "icc";
    case Keyed = "keyed";
    case Swiped = "swiped";
    case SwipedFallback = "swipedFallback";
    case ContactlessIcc = "contactlessIcc";
    case ContactlessMsr = "contactlessMsr";
}
