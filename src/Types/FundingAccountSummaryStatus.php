<?php

namespace Payroc\Types;

enum FundingAccountSummaryStatus: string
{
    case Approved = "approved";
    case Rejected = "rejected";
    case Pending = "pending";
}
