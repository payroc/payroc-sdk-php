<?php

namespace Payroc\Types;

enum OrderItemSolutionSetupDeviceSettingsCommunicationType: string
{
    case Bluetooth = "bluetooth";
    case Cellular = "cellular";
    case Ethernet = "ethernet";
    case Wifi = "wifi";
}
