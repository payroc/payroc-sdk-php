<?php

namespace Payroc\Types;

enum SecurityCheckCvvResult: string
{
    case M = "M";
    case N = "N";
    case P = "P";
    case U = "U";
}
