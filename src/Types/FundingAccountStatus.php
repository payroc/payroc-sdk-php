<?php

namespace Payroc\Types;

enum FundingAccountStatus: string
{
    case Approved = "approved";
    case Rejected = "rejected";
    case Pending = "pending";
    case Hold = "hold";
}
