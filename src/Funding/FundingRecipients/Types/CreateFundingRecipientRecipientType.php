<?php

namespace Payroc\Funding\FundingRecipients\Types;

enum CreateFundingRecipientRecipientType: string
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
