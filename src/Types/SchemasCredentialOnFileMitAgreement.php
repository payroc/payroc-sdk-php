<?php

namespace Payroc\Types;

enum SchemasCredentialOnFileMitAgreement: string
{
    case Unscheduled = "unscheduled";
    case Recurring = "recurring";
    case Installment = "installment";
}
