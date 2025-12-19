<?php

namespace Payroc\Types;

enum MultiUsePaymentLinkAuthType: string
{
    case Sale = "sale";
    case PreAuthorization = "preAuthorization";
}
