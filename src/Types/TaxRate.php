<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class TaxRate extends JsonSerializableType
{
    /**
     * @var value-of<TaxRateType> $type Indicates that the tax is a rate.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var float $rate Tax percentage for the transaction.
     */
    #[JsonProperty('rate')]
    public float $rate;

    /**
     * @var string $name Name of the tax. A tax validation on the stored rate for the tax name is performed.
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @param array{
     *   type: value-of<TaxRateType>,
     *   rate: float,
     *   name: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->rate = $values['rate'];
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
