<?php

namespace Payroc\Types;

enum StandingInstructionsProcessingModel: string
{
    case Unscheduled = "unscheduled";
    case Recurring = "recurring";
    case Installment = "installment";
}
