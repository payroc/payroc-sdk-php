<?php

namespace Payroc\Types;

enum CustomizationOptionsEntryMethod: string
{
    case DeviceRead = "deviceRead";
    case ManualEntry = "manualEntry";
    case DeviceReadOrManualEntry = "deviceReadOrManualEntry";
}
