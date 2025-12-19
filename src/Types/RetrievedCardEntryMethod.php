<?php

namespace Payroc\Types;

enum RetrievedCardEntryMethod: string
{
    case Icc = "icc";
    case Keyed = "keyed";
    case Swiped = "swiped";
    case SwipedFallback = "swipedFallback";
    case ContactlessIcc = "contactlessIcc";
    case ContactlessMsr = "contactlessMsr";
}
