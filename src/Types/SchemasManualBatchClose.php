<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;

/**
 * Indicates how authorized transactions will be batched for settlement
 */
class SchemasManualBatchClose extends JsonSerializableType
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
