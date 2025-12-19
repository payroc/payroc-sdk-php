<?php

namespace Payroc\CardPayments\Refunds\Types;

enum ListRefundsRequestStatusItem: string
{
    case Ready = "ready";
    case Pending = "pending";
    case Declined = "declined";
    case Complete = "complete";
    case Referral = "referral";
    case Pickup = "pickup";
    case Reversal = "reversal";
    case Admin = "admin";
    case Expired = "expired";
    case Accepted = "accepted";
}
