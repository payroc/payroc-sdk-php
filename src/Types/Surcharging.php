<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains surcharge information. Our gateway returns this object only if the merchant adds a surcharge to transactions.
 */
class Surcharging extends JsonSerializableType
{
    /**
     * @var bool $allowed Indicates if the merchant can add a surcharge when the customer uses this card.
     */
    #[JsonProperty('allowed')]
    public bool $allowed;

    /**
     * Surcharge amount to add to the transaction.
     * **Note:** Our gateway returns the surcharge amount only if you include a transaction amount in the request.
     *
     * @var ?int $amount
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?float $percentage Surcharge rate that the merchant configures on their account.
     */
    #[JsonProperty('percentage')]
    public ?float $percentage;

    /**
     * @var ?string $disclosure Statement that informs the customer about the surcharge fee.
     */
    #[JsonProperty('disclosure')]
    public ?string $disclosure;

    /**
     * @param array{
     *   allowed: bool,
     *   amount?: ?int,
     *   percentage?: ?float,
     *   disclosure?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->allowed = $values['allowed'];
        $this->amount = $values['amount'] ?? null;
        $this->percentage = $values['percentage'] ?? null;
        $this->disclosure = $values['disclosure'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
