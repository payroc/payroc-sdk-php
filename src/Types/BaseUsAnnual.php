<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class BaseUsAnnual extends JsonSerializableType
{
    /**
     * @var ?int $amount Fee for the Platinum Security, this is returned in the lowest unit of currency. For example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @param array{
     *   amount?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
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
