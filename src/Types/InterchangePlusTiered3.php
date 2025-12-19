<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about Interchange Plus with three tiers.
 */
class InterchangePlusTiered3 extends JsonSerializableType
{
    /**
     * @var InterchangePlusTiered3Fees $fees Object that contains information about the fees.
     */
    #[JsonProperty('fees')]
    public InterchangePlusTiered3Fees $fees;

    /**
     * @param array{
     *   fees: InterchangePlusTiered3Fees,
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
