<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about Interchange Plus.
 */
class InterchangePlusUs52 extends JsonSerializableType
{
    /**
     * @var InterchangePlusUs52Fees $fees Object that contains information about the fees.
     */
    #[JsonProperty('fees')]
    public InterchangePlusUs52Fees $fees;

    /**
     * @param array{
     *   fees: InterchangePlusUs52Fees,
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
