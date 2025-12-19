<?php

namespace Payroc\Traits;

use Payroc\Types\ProcessingTerminalSummary;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Array of links related to your order items.
 *
 * @property ?array<ProcessingTerminalSummary> $links
 */
trait Links
{
    /**
     * @var ?array<ProcessingTerminalSummary> $links
     */
    #[JsonProperty('links'), ArrayType([ProcessingTerminalSummary::class])]
    public ?array $links;
}
