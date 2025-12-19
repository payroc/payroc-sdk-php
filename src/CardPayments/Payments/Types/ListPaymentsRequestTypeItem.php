<?php

namespace Payroc\CardPayments\Payments\Types;

enum ListPaymentsRequestTypeItem: string
{
    case Sale = "sale";
    case PreAuthorization = "preAuthorization";
    case PreAuthorizationCompletion = "preAuthorizationCompletion";
}
