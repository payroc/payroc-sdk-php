<?php

namespace Payroc\Types;

enum BusinessOrganizationType: string
{
    case PrivateCorporation = "privateCorporation";
    case PublicCorporation = "publicCorporation";
    case NonProfit = "nonProfit";
    case PrivateLlc = "privateLlc";
    case PublicLlc = "publicLlc";
    case PrivatePartnership = "privatePartnership";
    case PublicPartnership = "publicPartnership";
    case SoleProprietor = "soleProprietor";
}
