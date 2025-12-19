<?php

namespace Payroc\Types;

enum CreateProcessingAccountBusinessType: string
{
    case Retail = "retail";
    case Restaurant = "restaurant";
    case Internet = "internet";
    case Moto = "moto";
    case Lodging = "lodging";
    case NotForProfit = "notForProfit";
}
