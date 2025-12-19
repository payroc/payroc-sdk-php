<?php

namespace Payroc\Types;

enum CardSummaryType: string
{
    case Visa = "visa";
    case MasterCard = "masterCard";
    case Discover = "discover";
    case Debit = "debit";
    case Ebt = "ebt";
    case WrightExpress = "wrightExpress";
    case Voyager = "voyager";
    case Amex = "amex";
    case PrivateLabel = "privateLabel";
    case StoredValue = "storedValue";
    case DiscoverRetained = "discoverRetained";
    case JcbNonSettled = "jcbNonSettled";
    case DinersClub = "dinersClub";
    case AmexOptBlue = "amexOptBlue";
    case Fuelman = "fuelman";
    case Unknown = "unknown";
}
