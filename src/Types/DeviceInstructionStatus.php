<?php

namespace Payroc\Types;

enum DeviceInstructionStatus: string
{
    case Canceled = "canceled";
    case Completed = "completed";
    case Failure = "failure";
    case InProgress = "inProgress";
}
