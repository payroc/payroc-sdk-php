<?php

namespace Payroc\Tokenization\SingleUseTokens\Types;

enum SingleUseTokenRequestChannel: string
{
    case Pos = "pos";
    case Web = "web";
    case Moto = "moto";
}
