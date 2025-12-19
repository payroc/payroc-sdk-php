<?php

namespace Payroc\Types;

enum SingleUseTokenPayloadSecCode: string
{
    case Web = "web";
    case Tel = "tel";
    case Ccd = "ccd";
    case Ppd = "ppd";
}
