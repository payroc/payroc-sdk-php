<?php

namespace Payroc\Types;

enum TransactionSummaryEntryMethod: string
{
    case BarcodeRead = "barcodeRead";
    case SmartChipRead = "smartChipRead";
    case SwipedOriginUnknown = "swipedOriginUnknown";
    case ContactlessChip = "contactlessChip";
    case Ecommerce = "ecommerce";
    case ManuallyEntered = "manuallyEntered";
    case ManuallyEnteredFallback = "manuallyEnteredFallback";
    case Swiped = "swiped";
    case SwipedFallback = "swipedFallback";
    case SwipedError = "swipedError";
    case ScannedCheckReader = "scannedCheckReader";
    case CredentialOnFile = "credentialOnFile";
    case Unknown = "unknown";
}
