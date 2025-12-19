<?php

namespace Payroc\Types;

enum PadPayloadAccountType: string
{
    case Checking = "checking";
    case Savings = "savings";
}
