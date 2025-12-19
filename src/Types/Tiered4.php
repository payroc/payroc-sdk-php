<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about tiered pricing with four tiers.
 */
class Tiered4 extends JsonSerializableType
{
    /**
     * @var Tiered4Fees $fees Object that contains information about the fees.
     */
    #[JsonProperty('fees')]
    public Tiered4Fees $fees;

    /**
     * @param array{
     *   fees: Tiered4Fees,
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
