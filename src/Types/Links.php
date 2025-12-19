<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Array of links related to your order items.
 */
class Links extends JsonSerializableType
{
    /**
     * @var ?array<ProcessingTerminalSummary> $links
     */
    #[JsonProperty('links'), ArrayType([ProcessingTerminalSummary::class])]
    public ?array $links;

    /**
     * @param array{
     *   links?: ?array<ProcessingTerminalSummary>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->links = $values['links'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
