<?php

namespace Payroc\Types;

enum ThirdPartyThreeDSecureEci: string
{
    case FullyAuthenticated = "fullyAuthenticated";
    case AttemptedAuthentication = "attemptedAuthentication";
}
