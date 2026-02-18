<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the funds that we send to the funding account.
 */
class InstructionMerchantsItemRecipientsItemAmount extends JsonSerializableType
{
    /**
     * @var int $value Amount of funds in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('value')]
    public int $value;

    /**
     * @var ?value-of<InstructionMerchantsItemRecipientsItemAmountCurrency> $currency Currency of the value parameter.
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @param array{
     *   value: int,
     *   currency?: ?value-of<InstructionMerchantsItemRecipientsItemAmountCurrency>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->value = $values['value'];
        $this->currency = $values['currency'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
