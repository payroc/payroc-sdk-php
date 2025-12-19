<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the pricing agreement reminder.
 */
class PricingAgreementReminder extends JsonSerializableType
{
    /**
     * @var ?string $reminderId Unique ID of the reminder.
     */
    #[JsonProperty('reminderId')]
    public ?string $reminderId;

    /**
     * @param array{
     *   reminderId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->reminderId = $values['reminderId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
