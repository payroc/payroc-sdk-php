<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;

/**
 * Object that contains signature information if we captured the merchant’s signature by email.
 */
class SignatureByEmail extends JsonSerializableType
{
    /**
     * @param array{
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        unset($values);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
