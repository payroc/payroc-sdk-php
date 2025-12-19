<?php

namespace Payroc\Types;

enum SecurityCheckAvsResult: string
{
    case Y = "Y";
    case A = "A";
    case Z = "Z";
    case N = "N";
    case U = "U";
    case R = "R";
    case G = "G";
    case S = "S";
    case F = "F";
    case W = "W";
    case X = "X";
}
