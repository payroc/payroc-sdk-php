<?php

namespace Payroc\Types;

enum TransactionResultType: string
{
    case Sale = "sale";
    case Refund = "refund";
    case PreAuthorization = "preAuthorization";
    case PreAuthorizationCompletion = "preAuthorizationCompletion";
}
