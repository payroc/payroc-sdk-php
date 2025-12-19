<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class TaxAmount extends JsonSerializableType
{
    /**
     * @var int $amount Tax amount for the transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @var string $name Name of the tax.
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @param array{
     *   amount: int,
     *   name: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->amount = $values['amount'];
        $this->name = $values['name'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
