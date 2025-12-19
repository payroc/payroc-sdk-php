<?php

namespace Payroc\Types;

enum DeviceCategory: string
{
    case Attended = "attended";
    case Unattended = "unattended";
}
