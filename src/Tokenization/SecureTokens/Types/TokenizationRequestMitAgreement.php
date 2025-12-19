<?php

namespace Payroc\Tokenization\SecureTokens\Types;

enum TokenizationRequestMitAgreement: string
{
    case Unscheduled = "unscheduled";
    case Recurring = "recurring";
    case Installment = "installment";
}
