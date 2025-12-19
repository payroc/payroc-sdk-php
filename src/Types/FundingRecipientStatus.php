<?php

namespace Payroc\Types;

enum FundingRecipientStatus: string
{
    case Approved = "approved";
    case Rejected = "rejected";
    case Pending = "pending";
}
