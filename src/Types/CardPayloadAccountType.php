<?php

namespace Payroc\Types;

enum CardPayloadAccountType: string
{
    case Checking = "checking";
    case Savings = "savings";
}
