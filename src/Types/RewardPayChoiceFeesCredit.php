<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about fees for credit transactions.
 */
class RewardPayChoiceFeesCredit extends JsonSerializableType
{
    /**
     * @var ?value-of<RewardPayChoiceFeesCreditTips> $tips Indicates how the merchant manages tips.
     */
    #[JsonProperty('tips')]
    public ?string $tips;

    /**
     * @var ?float $cardChargePercentage Percentage of the total transaction amount that the processor charges the cardholder.
     */
    #[JsonProperty('cardChargePercentage')]
    public ?float $cardChargePercentage;

    /**
     * @var ?float $merchantChargePercentage Percentage of the total transaction amount that the processor charges the merchant.
     */
    #[JsonProperty('merchantChargePercentage')]
    public ?float $merchantChargePercentage;

    /**
     * @var ?int $merchantChargePerTransaction Fee for each transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('merchantChargePerTransaction')]
    public ?int $merchantChargePerTransaction;

    /**
     * @param array{
     *   tips?: ?value-of<RewardPayChoiceFeesCreditTips>,
     *   cardChargePercentage?: ?float,
     *   merchantChargePercentage?: ?float,
     *   merchantChargePerTransaction?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->tips = $values['tips'] ?? null;
        $this->cardChargePercentage = $values['cardChargePercentage'] ?? null;
        $this->merchantChargePercentage = $values['merchantChargePercentage'] ?? null;
        $this->merchantChargePerTransaction = $values['merchantChargePerTransaction'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
