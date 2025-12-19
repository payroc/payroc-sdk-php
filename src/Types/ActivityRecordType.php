<?php

namespace Payroc\Types;

enum ActivityRecordType: string
{
    case Credit = "credit";
    case Debit = "debit";
}
