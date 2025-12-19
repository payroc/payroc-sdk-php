<?php

namespace Payroc\Types;

enum DigitalWalletPayloadAccountType: string
{
    case Checking = "checking";
    case Savings = "savings";
}
