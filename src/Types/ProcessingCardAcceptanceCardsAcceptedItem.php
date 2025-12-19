<?php

namespace Payroc\Types;

enum ProcessingCardAcceptanceCardsAcceptedItem: string
{
    case Visa = "visa";
    case Mastercard = "mastercard";
    case Discover = "discover";
    case AmexOptBlue = "amexOptBlue";
}
