<?php

namespace Payroc\Types;

enum DisputeStatusStatus: string
{
    case PrearbitrationInProcess = "prearbitrationInProcess";
    case PrearbitrationAccepted = "prearbitrationAccepted";
    case PrearbitrationDeclined = "prearbitrationDeclined";
    case ArbitrationFiledWithCardBand = "arbitrationFiledWithCardBand";
    case ArbitrationFundsToBeReturned = "arbitrationFundsToBeReturned";
    case ArbitrationLost = "arbitrationLost";
    case ArbitrationSettledPartialAmount = "arbitrationSettledPartialAmount";
    case PrecomplianceInProcess = "precomplianceInProcess";
    case PrecomplianceAccepted = "precomplianceAccepted";
    case PrecomplianceDeclined = "precomplianceDeclined";
    case ComplianceFiledWithCardBand = "complianceFiledWithCardBand";
    case ComplianceLost = "complianceLost";
    case ComplianceSettledPartialAmount = "complianceSettledPartialAmount";
    case Invalid = "invalid";
    case IssuerReversal = "issuerReversal";
    case New_ = "new";
    case Rejected = "rejected";
    case RepresentmentInProgress = "representmentInProgress";
    case RepresentmentFailed = "representmentFailed";
    case RepresentmentPaid = "representmentPaid";
    case RepresentmentReceived = "representmentReceived";
    case Stand = "stand";
}
