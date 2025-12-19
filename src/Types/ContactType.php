<?php

namespace Payroc\Types;

enum ContactType: string
{
    case Manager = "manager";
    case Representative = "representative";
    case Others = "others";
}
