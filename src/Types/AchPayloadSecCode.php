<?php

namespace Payroc\Types;

enum AchPayloadSecCode: string
{
    case Web = "web";
    case Tel = "tel";
    case Ccd = "ccd";
    case Ppd = "ppd";
}
