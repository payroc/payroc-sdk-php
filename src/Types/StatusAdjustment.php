<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the adjustment to the transaction. Send this object if the merchant is adjusting the status of the transaction.
 */
class StatusAdjustment extends JsonSerializableType
{
    /**
     * @var value-of<StatusAdjustmentToStatus> $toStatus Status that you want to change the transaction to.
     */
    #[JsonProperty('toStatus')]
    public string $toStatus;

    /**
     * @param array{
     *   toStatus: value-of<StatusAdjustmentToStatus>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->toStatus = $values['toStatus'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
