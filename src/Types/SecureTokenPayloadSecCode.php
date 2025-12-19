<?php

namespace Payroc\Types;

enum SecureTokenPayloadSecCode: string
{
    case Web = "web";
    case Tel = "tel";
    case Ccd = "ccd";
    case Ppd = "ppd";
}
