<?php

namespace Payroc\Types;

enum SwipedCardDetailsDowngradeTo: string
{
    case Keyed = "keyed";
    case Swiped = "swiped";
}
