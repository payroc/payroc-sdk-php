<?php

namespace Payroc\Types;

enum TerminalOrderTrainingProvider: string
{
    case Partner = "partner";
    case Payroc = "payroc";
}
