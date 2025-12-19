<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Indicates how authorized transactions will be batched for settlement
 */
class SchemasAutomaticBatchClose extends JsonSerializableType
{
    /**
     * @var string $batchCloseTime The time, within the specified timezone, at which the batch automatically closes
     */
    #[JsonProperty('batchCloseTime')]
    public string $batchCloseTime;

    /**
     * @param array{
     *   batchCloseTime: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->batchCloseTime = $values['batchCloseTime'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
