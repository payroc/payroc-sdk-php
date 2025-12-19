<?php

namespace Payroc\Types;

enum ProcessingTerminalStatus: string
{
    case Active = "active";
    case Inactive = "inactive";
}
