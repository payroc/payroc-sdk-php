<?php

namespace Payroc\Types;

enum InstructionStatus: string
{
    case Accepted = "accepted";
    case Pending = "pending";
    case Completed = "completed";
}
