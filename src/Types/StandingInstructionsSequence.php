<?php

namespace Payroc\Types;

enum StandingInstructionsSequence: string
{
    case First = "first";
    case Subsequent = "subsequent";
}
