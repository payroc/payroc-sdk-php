<?php

namespace Payroc\Types;

enum AchBankAccountSecCode: string
{
    case Web = "web";
    case Tel = "tel";
    case Ccd = "ccd";
    case Ppd = "ppd";
}
