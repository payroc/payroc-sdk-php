<?php

namespace Payroc\Types;

enum TrainingProvider: string
{
    case Partner = "partner";
    case Payroc = "payroc";
}
