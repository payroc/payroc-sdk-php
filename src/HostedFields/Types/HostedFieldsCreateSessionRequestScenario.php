<?php

namespace Payroc\HostedFields\Types;

enum HostedFieldsCreateSessionRequestScenario: string
{
    case Payment = "payment";
    case Tokenization = "tokenization";
}
