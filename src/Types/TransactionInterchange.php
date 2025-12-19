<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the interchange fees for the transaction.
 */
class TransactionInterchange extends JsonSerializableType
{
    /**
     * @var ?int $basisPoint Interchange basis points that we apply to the transaction.
     */
    #[JsonProperty('basisPoint')]
    public ?int $basisPoint;

    /**
     * @var ?int $transactionFee Interchange fee for the transaction. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('transactionFee')]
    public ?int $transactionFee;

    /**
     * @param array{
     *   basisPoint?: ?int,
     *   transactionFee?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->basisPoint = $values['basisPoint'] ?? null;
        $this->transactionFee = $values['transactionFee'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
