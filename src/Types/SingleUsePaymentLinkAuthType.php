<?php

namespace Payroc\Types;

enum SingleUsePaymentLinkAuthType: string
{
    case Sale = "sale";
    case PreAuthorization = "preAuthorization";
}
