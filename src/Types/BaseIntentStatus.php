<?php

namespace Payroc\Types;

enum BaseIntentStatus: string
{
    case Active = "active";
    case PendingReview = "pendingReview";
    case Rejected = "rejected";
}
