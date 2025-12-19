<?php

namespace Payroc\Types;

enum FundingRecipientFundingAccountsItemStatus: string
{
    case Approved = "approved";
    case Rejected = "rejected";
    case Pending = "pending";
    case Hold = "hold";
}
