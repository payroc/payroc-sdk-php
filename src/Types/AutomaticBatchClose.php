<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Indicates how the merchant batches their transactions.
 */
class AutomaticBatchClose extends JsonSerializableType
{
    /**
     * @var ?string $batchCloseTime Time that the batch automatically closes.
     */
    #[JsonProperty('batchCloseTime')]
    public ?string $batchCloseTime;

    /**
     * @param array{
     *   batchCloseTime?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->batchCloseTime = $values['batchCloseTime'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
