<?php

namespace Payroc\Types;

enum DisputeDisputeType: string
{
    case Prearbitration = "prearbitration";
    case IssuerReversal = "issuerReversal";
    case FirstDisputeWithReversal = "firstDisputeWithReversal";
    case FirstDispute = "firstDispute";
}
