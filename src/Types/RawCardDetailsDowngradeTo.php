<?php

namespace Payroc\Types;

enum RawCardDetailsDowngradeTo: string
{
    case Keyed = "keyed";
    case Swiped = "swiped";
}
