<?php

namespace Payroc\Types;

enum ProcessingTerminalFeaturesEnhancedProcessingShippingAddressMode: string
{
    case FullAddress = "fullAddress";
    case PostalCode = "postalCode";
}
