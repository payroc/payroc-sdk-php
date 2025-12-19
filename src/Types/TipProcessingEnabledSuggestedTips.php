<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains up to three tip amounts that the terminal displays during a sale.
 */
class TipProcessingEnabledSuggestedTips extends JsonSerializableType
{
    /**
     * @var ?bool $enabled Indicates if the terminal displays tip amounts during a sale.
     */
    #[JsonProperty('enabled')]
    public ?bool $enabled;

    /**
     * @var ?array<string> $tipPercentages Array of the tip amounts that the terminal displays during a sale.
     */
    #[JsonProperty('tipPercentages'), ArrayType(['string'])]
    public ?array $tipPercentages;

    /**
     * @param array{
     *   enabled?: ?bool,
     *   tipPercentages?: ?array<string>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->enabled = $values['enabled'] ?? null;
        $this->tipPercentages = $values['tipPercentages'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
