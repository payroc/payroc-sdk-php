<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the annual fee.
 */
class BaseUsAnnualFee extends JsonSerializableType
{
    /**
     * @var ?value-of<BaseUsAnnualFeeBillInMonth> $billInMonth Indicates whether we collect the annual fee in June or December.
     */
    #[JsonProperty('billInMonth')]
    public ?string $billInMonth;

    /**
     * @var int $amount Annual fee. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @param array{
     *   amount: int,
     *   billInMonth?: ?value-of<BaseUsAnnualFeeBillInMonth>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->billInMonth = $values['billInMonth'] ?? null;
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
