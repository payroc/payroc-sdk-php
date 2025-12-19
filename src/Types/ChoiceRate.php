<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the choice rate. We return this only if the value for offered was `true`.
 */
class ChoiceRate extends JsonSerializableType
{
    /**
     * Indicates if the merchant applies a choice rate to the transaction amount.
     *
     * Our gateway adds a choice rate to the transaction when the merchant offers an alternative payment type, but the customer chooses to pay by card.
     *
     * @var bool $applied
     */
    #[JsonProperty('applied')]
    public bool $applied;

    /**
     * If the customer used a card to pay for the transaction, this value indicates the percentage that our gateway added to the transaction amount.
     * **Note:** Our gateway returns a value for **rate** only if the value for **applied** in the request is `true`.
     *
     * @var float $rate
     */
    #[JsonProperty('rate')]
    public float $rate;

    /**
     * If the customer used a card to pay for the transaction, this value indicates the amount that our gateway added to the transaction amount. This value is in the currency’s lowest denomination, for example, cents.
     * **Note:** Our gateway returns a value for **amount** only if the value for **applied** in the request is `true`.
     *
     * @var int $amount
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @param array{
     *   applied: bool,
     *   rate: float,
     *   amount: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->applied = $values['applied'];
        $this->rate = $values['rate'];
        $this->amount = $values['amount'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
