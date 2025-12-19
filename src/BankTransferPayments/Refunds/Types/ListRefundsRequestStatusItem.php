<?php

namespace Payroc\BankTransferPayments\Refunds\Types;

enum ListRefundsRequestStatusItem: string
{
    case Ready = "ready";
    case Pending = "pending";
    case Declined = "declined";
    case Complete = "complete";
    case Admin = "admin";
    case Reversal = "reversal";
    case Returned = "returned";
}
