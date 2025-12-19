<?php

namespace Payroc\Types;

enum SecureTokenMitAgreement: string
{
    case Unscheduled = "unscheduled";
    case Recurring = "recurring";
    case Installment = "installment";
}
