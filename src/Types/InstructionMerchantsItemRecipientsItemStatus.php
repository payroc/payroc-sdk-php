<?php

namespace Payroc\Types;

enum InstructionMerchantsItemRecipientsItemStatus: string
{
    case Accepted = "accepted";
    case Pending = "pending";
    case Released = "released";
    case Funded = "funded";
    case Failed = "failed";
    case Rejected = "rejected";
    case OnHold = "onHold";
}
