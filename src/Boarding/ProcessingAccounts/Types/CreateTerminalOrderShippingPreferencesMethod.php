<?php

namespace Payroc\Boarding\ProcessingAccounts\Types;

enum CreateTerminalOrderShippingPreferencesMethod: string
{
    case NextDay = "nextDay";
    case Ground = "ground";
}
