<?php

namespace Payroc\Types;

enum ProcessingAccountStatus: string
{
    case Entered = "entered";
    case Pending = "pending";
    case Approved = "approved";
    case SubjectTo = "subjectTo";
    case Dormant = "dormant";
    case NonProcessing = "nonProcessing";
    case Rejected = "rejected";
    case Terminated = "terminated";
    case Cancelled = "cancelled";
}
