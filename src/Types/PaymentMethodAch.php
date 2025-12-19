<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class PaymentMethodAch extends JsonSerializableType
{
    /**
     * @var ?PaymentMethodAchValue $value Object that contains information about the funding account.
     */
    #[JsonProperty('value')]
    public ?PaymentMethodAchValue $value;

    /**
     * @param array{
     *   value?: ?PaymentMethodAchValue,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->value = $values['value'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
