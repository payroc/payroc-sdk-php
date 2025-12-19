<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;

/**
 * Indicates how the merchant batches their transactions.
 */
class ManualBatchClose extends JsonSerializableType
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
