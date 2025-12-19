<?php

namespace Payroc\Types;

enum SchemasTimezone: string
{
    case PacificMidway = "Pacific/Midway";
    case PacificHonolulu = "Pacific/Honolulu";
    case AmericaAnchorage = "America/Anchorage";
    case AmericaLosAngeles = "America/Los_Angeles";
    case AmericaDenver = "America/Denver";
    case AmericaPhoenix = "America/Phoenix";
    case AmericaChicago = "America/Chicago";
    case AmericaIndianaIndianapolis = "America/Indiana/Indianapolis";
    case AmericaNewYork = "America/New_York";
}
