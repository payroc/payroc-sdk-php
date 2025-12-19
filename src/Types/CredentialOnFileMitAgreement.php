<?php

namespace Payroc\Types;

enum CredentialOnFileMitAgreement: string
{
    case Unscheduled = "unscheduled";
    case Recurring = "recurring";
    case Installment = "installment";
}
