<?php

namespace Payroc\Attachments\Types;

enum AttachmentUploadStatus: string
{
    case Pending = "pending";
    case Accepted = "accepted";
    case Rejected = "rejected";
}
