<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about tiered pricing with six tiers.
 */
class Tiered6 extends JsonSerializableType
{
    /**
     * @var Tiered6Fees $fees Object that contains information about the fees.
     */
    #[JsonProperty('fees')]
    public Tiered6Fees $fees;

    /**
     * @param array{
     *   fees: Tiered6Fees,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->fees = $values['fees'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
