<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that indicates if the terminal can send email receipts or text receipts.
 */
class ProcessingTerminalReceiptNotifications extends JsonSerializableType
{
    /**
     * @var ?bool $emailReceipt Indicates if the terminal can send receipts by email.
     */
    #[JsonProperty('emailReceipt')]
    public ?bool $emailReceipt;

    /**
     * @var ?bool $smsReceipt Indicates if the terminal can send receipts by text message.
     */
    #[JsonProperty('smsReceipt')]
    public ?bool $smsReceipt;

    /**
     * @param array{
     *   emailReceipt?: ?bool,
     *   smsReceipt?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->emailReceipt = $values['emailReceipt'] ?? null;
        $this->smsReceipt = $values['smsReceipt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
