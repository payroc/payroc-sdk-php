<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about fees for debit transactions.
 */
class RewardPayChoiceFeesDebit extends JsonSerializableType
{
    /**
     * @var ?value-of<RewardPayChoiceFeesDebitOption> $option Indicates if debit transactions should be charged at interchange plus or flat rate pricing.
     */
    #[JsonProperty('option')]
    public ?string $option;

    /**
     * @var float $volume Percentage of the total transaction that the processor charges the merchant.
     */
    #[JsonProperty('volume')]
    public float $volume;

    /**
     * @var int $transaction Fee for each transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('transaction')]
    public int $transaction;

    /**
     * @param array{
     *   volume: float,
     *   transaction: int,
     *   option?: ?value-of<RewardPayChoiceFeesDebitOption>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->option = $values['option'] ?? null;
        $this->volume = $values['volume'];
        $this->transaction = $values['transaction'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
