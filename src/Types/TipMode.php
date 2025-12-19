<?php

namespace Payroc\Types;

enum TipMode: string
{
    case Prompted = "prompted";
    case Adjusted = "adjusted";
}
