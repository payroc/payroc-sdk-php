<?php

namespace Payroc\Types;

enum TerminalOrderShippingPreferencesMethod: string
{
    case NextDay = "nextDay";
    case Ground = "ground";
}
