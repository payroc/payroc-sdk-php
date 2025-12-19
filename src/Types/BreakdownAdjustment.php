<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the tip amount of a transaction.
 */
class BreakdownAdjustment extends JsonSerializableType
{
    /**
     * @var ?Tip $tip
     */
    #[JsonProperty('tip')]
    public ?Tip $tip;

    /**
     * @param array{
     *   tip?: ?Tip,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->tip = $values['tip'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
