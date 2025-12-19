<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about Flat Rate.
 */
class FlatRate extends JsonSerializableType
{
    /**
     * @var FlatRateFees $fees Object that contains information about the Flat Rate fees.
     */
    #[JsonProperty('fees')]
    public FlatRateFees $fees;

    /**
     * @param array{
     *   fees: FlatRateFees,
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
