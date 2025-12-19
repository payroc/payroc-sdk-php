<?php

namespace Payroc\Types;

enum SecureTokenStatus: string
{
    case NotValidated = "notValidated";
    case CvvValidated = "cvvValidated";
    case ValidationFailed = "validationFailed";
    case IssueNumberValidated = "issueNumberValidated";
    case CardNumberValidated = "cardNumberValidated";
    case BankAccountValidated = "bankAccountValidated";
}
