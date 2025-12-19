<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about Interchange Plus Plus.
 */
class InterchangePlusPlus extends JsonSerializableType
{
    /**
     * @var InterchangePlusPlusFees $fees Object that contains information about the fees.
     */
    #[JsonProperty('fees')]
    public InterchangePlusPlusFees $fees;

    /**
     * @param array{
     *   fees: InterchangePlusPlusFees,
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
