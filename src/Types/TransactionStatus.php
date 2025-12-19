<?php

namespace Payroc\Types;

enum TransactionStatus: string
{
    case FullSuspense = "fullSuspense";
    case HeldAudited = "heldAudited";
    case HeldReleasedAudited = "heldReleasedAudited";
    case HoldForSettlement30Days = "holdForSettlement30Days";
    case HoldForSettlementDuplicate = "holdForSettlementDuplicate";
    case HoldLongTerm = "holdLongTerm";
    case Paid = "paid";
    case PaidByThirdParty = "paidByThirdParty";
    case PartialRelease = "partialRelease";
    case Pull = "pull";
    case Release = "release";
    case New_ = "new";
    case Held = "held";
    case Unknown = "unknown";
}
