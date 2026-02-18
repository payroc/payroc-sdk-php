<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about U.S. processor fees.
 */
class PricingAgreementUs40Processor extends JsonSerializableType
{
    /**
     * Polymorphic object that contains fees for card transactions.
     *
     * The value of the planType field determines which variant you should use:
     * -	`interchangePlus` - Interchange + pricing
     * -	`interchangePlusTiered3` - Interchange pricing with three tiers
     * -	`tiered3` - Three-tiered pricing
     * -	`tiered4` - Four-tiered pricing
     * -	`tiered6` - Six-tiered pricing
     * -	`flatRate` - Flat rate pricing
     * -	`consumerChoice` - ConsumerChoice
     * -	`rewardPay` - RewardPay
     * -	`rewardPayChoice` - RewardPayChoice
     *
     * @var ?PricingAgreementUs40ProcessorCard $card
     */
    #[JsonProperty('card')]
    public ?PricingAgreementUs40ProcessorCard $card;

    /**
     * @var ?Ach $ach
     */
    #[JsonProperty('ach')]
    public ?Ach $ach;

    /**
     * @param array{
     *   card?: ?PricingAgreementUs40ProcessorCard,
     *   ach?: ?Ach,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->card = $values['card'] ?? null;
        $this->ach = $values['ach'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
