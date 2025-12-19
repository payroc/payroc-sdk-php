<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about Interchange Plus.
 */
class InterchangePlus extends JsonSerializableType
{
    /**
     * @var InterchangePlusFees $fees Object that contains information about the fees.
     */
    #[JsonProperty('fees')]
    public InterchangePlusFees $fees;

    /**
     * @param array{
     *   fees: InterchangePlusFees,
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
