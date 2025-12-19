<?php

namespace Payroc\Types;

enum ProcessingTerminalSecurityAvsLevel: string
{
    case FullAddress = "fullAddress";
    case PostalCode = "postalCode";
}
