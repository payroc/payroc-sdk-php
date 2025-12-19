<?php

namespace Payroc\Types;

enum DigitalWalletPayloadServiceProvider: string
{
    case Apple = "apple";
    case Google = "google";
}
