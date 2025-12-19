<?php

namespace Payroc\Types;

enum TransactionResultResponseCode: string
{
    case A = "A";
    case D = "D";
    case E = "E";
    case P = "P";
    case R = "R";
    case C = "C";
}
