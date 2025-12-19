<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class RetrievedTax extends JsonSerializableType
{
    /**
     * @var string $name Name of the tax.
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var float $rate Tax percentage for the transaction.
     */
    #[JsonProperty('rate')]
    public float $rate;

    /**
     * @var ?int $amount Amount of tax that was applied to the transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @param array{
     *   name: string,
     *   rate: float,
     *   amount?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->name = $values['name'];
        $this->rate = $values['rate'];
        $this->amount = $values['amount'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
