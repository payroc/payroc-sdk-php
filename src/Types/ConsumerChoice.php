<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about ConsumerChoice.
 */
class ConsumerChoice extends JsonSerializableType
{
    /**
     * @var ConsumerChoiceFees $fees Object that contains information about the fees.
     */
    #[JsonProperty('fees')]
    public ConsumerChoiceFees $fees;

    /**
     * @param array{
     *   fees: ConsumerChoiceFees,
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
