<?php

namespace Payroc\Types;

enum BankTransferResultStatus: string
{
    case Ready = "ready";
    case Pending = "pending";
    case Declined = "declined";
    case Complete = "complete";
    case Admin = "admin";
    case Reversal = "reversal";
    case Returned = "returned";
}
