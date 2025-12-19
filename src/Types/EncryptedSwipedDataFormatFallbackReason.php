<?php

namespace Payroc\Types;

enum EncryptedSwipedDataFormatFallbackReason: string
{
    case Technical = "technical";
    case RepeatFallback = "repeatFallback";
    case EmptyCandidateList = "emptyCandidateList";
}
