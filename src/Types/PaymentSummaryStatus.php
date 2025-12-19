<?php

namespace Payroc\Types;

enum PaymentSummaryStatus: string
{
    case Ready = "ready";
    case Pending = "pending";
    case Declined = "declined";
    case Complete = "complete";
    case Referral = "referral";
    case Pickup = "pickup";
    case Reversal = "reversal";
    case Returned = "returned";
    case Admin = "admin";
    case Expired = "expired";
    case Accepted = "accepted";
}
