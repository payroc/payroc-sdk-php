<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the transaction if the merchant ran it when the terminal was offline.
 */
class OfflineProcessing extends JsonSerializableType
{
    /**
     * @var value-of<OfflineProcessingOperation> $operation Status of the transaction.
     */
    #[JsonProperty('operation')]
    public string $operation;

    /**
     * @var ?string $approvalCode Approval code for the transaction from the processor.
     */
    #[JsonProperty('approvalCode')]
    public ?string $approvalCode;

    /**
     * @var ?DateTime $dateTime Date and time that the merchant ran the transaction. The date follows the ISO 8601 standard.
     */
    #[JsonProperty('dateTime'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $dateTime;

    /**
     * @param array{
     *   operation: value-of<OfflineProcessingOperation>,
     *   approvalCode?: ?string,
     *   dateTime?: ?DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->operation = $values['operation'];
        $this->approvalCode = $values['approvalCode'] ?? null;
        $this->dateTime = $values['dateTime'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
