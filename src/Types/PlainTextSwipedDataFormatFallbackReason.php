<?php

namespace Payroc\Types;

enum PlainTextSwipedDataFormatFallbackReason: string
{
    case Technical = "technical";
    case RepeatFallback = "repeatFallback";
    case EmptyCandidateList = "emptyCandidateList";
}
