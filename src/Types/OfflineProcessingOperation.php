<?php

namespace Payroc\Types;

enum OfflineProcessingOperation: string
{
    case OfflineDecline = "offlineDecline";
    case OfflineApproval = "offlineApproval";
    case DeferredAuthorization = "deferredAuthorization";
}
