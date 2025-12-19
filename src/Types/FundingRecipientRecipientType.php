<?php

namespace Payroc\Types;

enum FundingRecipientRecipientType: string
{
    case PrivateCorporation = "privateCorporation";
    case PublicCorporation = "publicCorporation";
    case NonProfit = "nonProfit";
    case Government = "government";
    case PrivateLlc = "privateLlc";
    case PublicLlc = "publicLlc";
    case PrivatePartnership = "privatePartnership";
    case PublicPartnership = "publicPartnership";
    case SoleProprietor = "soleProprietor";
}
