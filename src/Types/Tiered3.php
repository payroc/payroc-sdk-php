<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about tiered pricing with three tiers.
 */
class Tiered3 extends JsonSerializableType
{
    /**
     * @var Tiered3Fees $fees Object that contains information about the fees.
     */
    #[JsonProperty('fees')]
    public Tiered3Fees $fees;

    /**
     * @param array{
     *   fees: Tiered3Fees,
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
