<?php

namespace Payroc\Types;

enum SecureTokenPayloadAccountType: string
{
    case Checking = "checking";
    case Savings = "savings";
}
