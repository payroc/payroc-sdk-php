<?php

namespace Payroc\Types;

enum IccCardDetailsDowngradeTo: string
{
    case Keyed = "keyed";
    case Swiped = "swiped";
}
