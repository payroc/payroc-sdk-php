<?php

namespace Payroc\Types;

enum CommunicationType: string
{
    case Bluetooth = "bluetooth";
    case Cellular = "cellular";
    case Ethernet = "ethernet";
    case Wifi = "wifi";
}
